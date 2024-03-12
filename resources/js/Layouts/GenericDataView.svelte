<script>
    import { debounce } from 'lodash';
    import { showConfirmDialog, showErrorDialog, showSuccessDialog, showDeclinedDialog } from '../Helpers/showDialog';
    import DashboardLayout from './DashboardLayout.svelte';
    import { inertia } from '@inertiajs/svelte';
    import Pagination from '../Components/Pagination.svelte';
    import { dataViewMode, toggleViewMode } from '../Stores/dataViewModeStore';
    import loading from '../Stores/loadingOverlayStore';

    export let fetchItems;
    export let deleteItem;
    export let title;
    export let createUrl;
    export let showCards = true;

    let previousSearch = '';
    let search = '';
    let page = 1;
    let itemsData;

    const DEBOUNCE_TIME = 300;
    const DEFAULT_FILTERS = {
        options: {
            filters: {
                search: '',
            },
        },
        page: 1,
    };
    const SORT_OPTIONS = {
        sortBy: 'updated_at',
        sortDirection: 'desc',
    };

    let filters = { ...DEFAULT_FILTERS };

    const refreshItems = async () => {
        loading.start('Fetching items');
        const options = { params: filters };
        itemsData = await fetchItems(options);
        loading.stop();
    };

    const debouncedFetchItems = debounce(async () => {
        await refreshItems();
    }, DEBOUNCE_TIME);

    $: {
        if (search && search !== previousSearch) {
            page = 1;
            previousSearch = search;
            console.log('search', search);
        }

        filters = {
            ...filters,
            options: {
                filters: {
                    search,
                },
                ...SORT_OPTIONS,
            },
            page,
        };

        debouncedFetchItems();
    }

    function handleChangeUrl(newUrl) {
        page = newUrl;
    }

    async function handleDeleteItem(id) {
        const result = await showConfirmDialog();

        if (!result.isConfirmed) {
            return showDeclinedDialog();
        } else {
            try {
                await deleteItem(id);
                await refreshItems();
                showSuccessDialog({ title: 'Success!', text: `${title} has been deleted` });
            } catch (error) {
                console.log(error);
                showErrorDialog();
            }
        }
    }
</script>

<DashboardLayout {title}>
    <div class="flex flex-col gap-5 mt-5">
        <div class="flex justify-between">
            <a use:inertia href={createUrl} class="btn btn-primary gap-2">
                <i class="ri-add-large-line"></i>
                <span>Add {title}</span>
            </a>

            <div class="flex gap-3 items-center">
                <div class="relative">
                    <input type="text" class="input input-bordered" bind:value={search} placeholder="Search" />
                    <div class="absolute top-1/2 right-3 -translate-y-1/2">
                        <i class="ri-search-line"></i>
                    </div>
                </div>

                <button class="btn btn-outline gap-2">
                    <i class="ri-sort-desc"></i>
                    <span>Sort</span>
                </button>

                <button class="btn btn-outline gap-2">
                    <i class="ri-equalizer-2-line"></i>
                    <span>Filter</span>
                </button>

                <button class="btn btn-outline gap-2" on:click={toggleViewMode}>
                    {#if $dataViewMode === 'table'}
                        <i class="ri-grid-line"></i>
                    {:else}
                        <i class="ri-bank-card-line"></i>
                    {/if}
                </button>
            </div>
        </div>

        {#if $dataViewMode === 'table' || !showCards}
            <slot name="tableView" {itemsData} {handleDeleteItem} />
        {:else}
            <slot name="cardsView" {itemsData} {handleDeleteItem} />
        {/if}

        <Pagination links={itemsData?.meta?.links} {handleChangeUrl} />
    </div>
</DashboardLayout>
