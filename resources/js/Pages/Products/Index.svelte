<script>
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import Pagination from '../../Components/Pagination.svelte';
    import DataViewProductCards from './DataViewModes/DataViewProductCards.svelte';
    import DataViewProductTable from './DataViewModes/DataViewProductTable.svelte';

    import loading from '../../Stores/loadingOverlayStore';
    import { toggleViewMode, dataViewMode } from '../../Stores/dataViewModeStore';

    import { Link } from '@inertiajs/svelte';
    import { debounce } from 'lodash';
    import {
        showConfirmDialog,
        showErrorDialog,
        showSuccessDialog,
        showDeclinedDialog,
    } from '../../Helpers/showDialog';

    const DEBOUNCE_TIME = 300;
    const DEFAULT_FILTERS = {
        options: {
            filters: {
                search: '',
            },
            sortBy: 'updated_at',
            sortDirection: 'desc',
        },
        page: 1,
    };
    const SORT_OPTIONS = {
        sortBy: 'updated_at',
        sortDirection: 'desc',
    };

    let filters = { ...DEFAULT_FILTERS };
    let page = 1;
    let productData;
    let previousSearch = '';
    let search = '';

    const debouncedFetchProducts = debounce(fetchProducts, DEBOUNCE_TIME);

    $: {
        if (search && search !== previousSearch) {
            page = 1;
            previousSearch = search;
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
        debouncedFetchProducts();
    }

    async function fetchProducts() {
        loading.start('Fetching products');
        const url = '/api/products';
        const options = { params: filters };
        const response = await axios.get(url, options);
        loading.stop();
        productData = response.data;
    }

    function handleChangeUrl(newUrl) {
        page = newUrl;
    }

    async function deleteProduct(id) {
        const result = await showConfirmDialog();

        if (!result.isConfirmed) {
            return showDeclinedDialog();
        } else {
            try {
                await axios.delete(`/api/products/${id}`);
                fetchProducts();
                showSuccessDialog({ title: 'Success!', text: 'Product has been deleted' });
            } catch (error) {
                console.log(error);
                showErrorDialog();
            } finally {
                loading.stop();
            }
        }
    }
</script>

<DashboardLayout title="Products">
    <div class="flex flex-col gap-5 mt-5">
        <div class="flex justify-between">
            <Link href="/products/create" class="btn btn-primary gap-2">
                <i class="ri-add-large-line"></i>
                <span>Add Product</span>
            </Link>

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

        {#if $dataViewMode === 'table'}
            <DataViewProductTable {productData} {deleteProduct} />
        {:else}
            <DataViewProductCards {productData} {deleteProduct} />
        {/if}

        <Pagination links={productData?.meta?.links} {handleChangeUrl} />
    </div>
</DashboardLayout>
