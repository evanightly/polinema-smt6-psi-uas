<script>
    import { debounce } from 'lodash';
    import { showConfirmDialog, showErrorDialog, showSuccessDialog, showDeclinedDialog } from '../Helpers/showDialog';
    import DashboardLayout from './DashboardLayout.svelte';
    import { inertia } from '@inertiajs/svelte';
    import Pagination from '../Components/Pagination.svelte';
    import { dataViewMode, toggleViewMode } from '../Stores/Data/dataViewModeStore';
    import loading from '../Stores/Utility/loadingOverlayStore';
    import _ from 'lodash';
    export let store;
    export let title = '';
    export let modelUrl = '';
    export let columns = [];
    export let additionalFilters = {};
    export let additionalButtons = [];
    export let showAddButton = true;
    export let showEditButton = true;
    export let showDeleteButton = true;
    export let showViewButton = true;

    const DEBOUNCE_TIME = 300;
    let previousSearch = '';
    let search = '';
    let page = 1;

    const debouncedFetchItems = debounce(async () => {
        loading.start('Loading');

        const options = _.merge(
            {
                params: {
                    options: { filters: { search }, sortBy: 'updated_at', sortDirection: 'desc' },
                    page,
                },
            },

            additionalFilters,
        );

        await store.fetch(options);
        loading.stop();
    }, DEBOUNCE_TIME);

    $: {
        if (search && search !== previousSearch) {
            page = 1;
            previousSearch = search;
        }
        page, debouncedFetchItems();
    }

    function handleChangeUrl(newUrl) {
        if (+newUrl === page) {
            return;
        }
        loading.start('Loading'); // This needs to be stopped, eventually it will stopped in debouncedFetchItems
        page = newUrl;
    }

    async function handleDeleteItem(id) {
        const result = await showConfirmDialog();

        if (!result.isConfirmed) {
            return showDeclinedDialog();
        } else {
            loading.start('Deleting');
            try {
                await store.delete(id);
                showSuccessDialog({ title: 'Success!', text: `${title} has been deleted` });
            } catch (error) {
                console.log(error);
                showErrorDialog();
            } finally {
                loading.stop();
            }
        }
    }

    function getNestedProperty(obj, column) {
        // Return the value of a nested property in an object.
        // If the property does not exist, return an empty string.
        let value = _.get(obj, column.key) ?? '';
        if (value === '') {
            value = column.fallbackValue ?? '';
        }
        return value;
    }
</script>

<DashboardLayout {title}>
    <div class="flex flex-col gap-5 py-6">
        <div class="flex justify-between">
            {#if modelUrl && showAddButton}
                <a use:inertia href={`${modelUrl}/create`} class="btn btn-primary gap-2">
                    <i class="ri-add-large-line"></i>
                    <span>Add {title}</span>
                </a>
            {:else}
                <div class="btn invisible">Invisible Text</div>
            {/if}

            <div class="flex gap-3 items-center">
                <div class="relative">
                    <input type="text" class="input input-bordered" bind:value={search} placeholder="Search" />
                    <div class="absolute top-1/2 right-3 -translate-y-1/2">
                        <i class="ri-search-line"></i>
                    </div>
                </div>

                {#each additionalButtons ?? [] as button (button.label)}
                    <button on:click={button.onClick}>{button.label}</button>
                {/each}

                <button class="btn btn-outline gap-2" on:click={toggleViewMode}>
                    {#if $dataViewMode === 'table'}
                        <i class="ri-grid-line"></i>
                    {:else}
                        <i class="ri-bank-card-line"></i>
                    {/if}
                </button>
            </div>
        </div>

        {#if $dataViewMode === 'table' && columns.length > 0 && $store?.data?.length > 0}
            <div class="flex w-full overflow-x-auto">
                <table class="table-hover table">
                    <thead>
                        <tr>
                            {#each columns as column}
                                <th>{column.label}</th>
                            {/each}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#each $store.data as item (item.id)}
                            <tr>
                                {#each columns as column}
                                    <td>
                                        {#if column.isImage}
                                            <img
                                                src={getNestedProperty(item, column)}
                                                alt={getNestedProperty(item, column)}
                                                class="h-24"
                                            />
                                        {:else}
                                            {getNestedProperty(item, column)}
                                        {/if}
                                    </td>
                                {/each}
                                <td>
                                    <div class="flex gap-2">
                                        {#if showViewButton}
                                            <a
                                                use:inertia
                                                href={`/${modelUrl}/${item.id}`}
                                                class="btn btn-sm btn-secondary"
                                            >
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        {/if}

                                        {#if showEditButton}
                                            <a
                                                use:inertia
                                                href={`/${modelUrl}/${item.id}/edit`}
                                                class="btn btn-sm btn-edit"
                                            >
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        {/if}

                                        {#if item?.implement_soft_delete || (showDeleteButton && item?.can_be_deleted)}
                                            <button
                                                on:click={() => handleDeleteItem(item.id)}
                                                class="btn btn-sm btn-delete"
                                            >
                                                <i class="ri-delete-bin-6-line"></i>
                                            </button>
                                        {/if}
                                    </div>
                                </td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            </div>
        {:else}
            <slot name="cardsView" store={$store} {handleDeleteItem} />
        {/if}

        <Pagination links={$store?.meta?.links} {handleChangeUrl} />
    </div>
</DashboardLayout>
