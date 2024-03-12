<script>
    import { debounce } from 'lodash';
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import DataViewTransactionTable from './DataViews/DataViewTransactionTable.svelte';

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
        const url = '/api/transactions';
        const { data: response } = await axios.get(url, options);
        return response;
    }

    async function deleteUser(id) {
        await axios.delete(`/api/transactions/${id}`);
    }
</script>

<GenericDataView
    fetchItems={fetchUsers}
    deleteItem={deleteUser}
    title="User"
    createUrl="transactions/create"
    showCards={false}
>
    <div slot="tableView" let:itemsData={transactionsData} let:handleDeleteItem>
        <DataViewTransactionTable {transactionsData} {handleDeleteItem} />
    </div>

    <div slot="cardsView" let:itemsData={transactionsData} let:handleDeleteItem></div>
</GenericDataView>
