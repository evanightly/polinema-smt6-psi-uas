<script>
    import { debounce } from 'lodash';
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import DataViewRoleTable from './DataViews/DataViewRoleTable.svelte';

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

    const debouncedFetchRoles = debounce(fetchRoles, DEBOUNCE_TIME);

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

        debouncedFetchRoles();
    }

    async function fetchRoles(options) {
        const url = '/api/roles';
        const { data: response } = await axios.get(url, options);
        return response;
    }

    async function deleteRole(id) {
        await axios.delete(`/api/roles/${id}`);
    }
</script>

<GenericDataView
    fetchItems={fetchRoles}
    deleteItem={deleteRole}
    title="Role"
    createUrl="roles/create"
    showCards={false}
>
    <div slot="tableView" let:itemsData={rolesData} let:handleDeleteItem>
        <DataViewRoleTable {rolesData} {handleDeleteItem} />
    </div>

    <div slot="cardsView" let:itemsData={rolesData} let:handleDeleteItem></div>
</GenericDataView>
