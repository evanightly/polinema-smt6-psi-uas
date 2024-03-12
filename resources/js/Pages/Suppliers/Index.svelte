<script>
    import { debounce } from 'lodash';
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import DataViewSupplierTable from './DataViews/DataViewSupplierTable.svelte';

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
    let page = 1;
    let previousSearch = '';
    let search = '';

    const debouncedFetchUsers = debounce(fetchUsers, DEBOUNCE_TIME);

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

        debouncedFetchUsers();
    }

    async function fetchUsers(options) {
        const url = '/api/suppliers';
        const { data: response } = await axios.get(url, options);
        return response;
    }

    async function deleteUser(id) {
        await axios.delete(`/api/suppliers/${id}`);
    }
</script>

<GenericDataView
    fetchItems={fetchUsers}
    deleteItem={deleteUser}
    title="User"
    createUrl="suppliers/create"
    showCards={false}
>
    <div slot="tableView" let:itemsData={suppliersData} let:handleDeleteItem>
        <DataViewSupplierTable {suppliersData} {handleDeleteItem} />
    </div>

    <div slot="cardsView" let:itemsData={suppliersData} let:handleDeleteItem></div>
</GenericDataView>
