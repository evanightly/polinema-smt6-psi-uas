<script>
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import { roleStore } from '../../Stores/Data/roleStore';

    let title = 'Role';
    const modelUrl = 'roles';
    const columns = [
        {
            key: 'name',
            label: 'Name',
        },
        {
            key: 'users_total',
            label: 'User Total',
        },
    ];

    const store = roleStore();
</script>

<GenericDataView {store} {title} {modelUrl} {columns} showAddButton={false}>
    <div slot="cardsView" let:handleDeleteItem>Not Implemented Yet</div>
</GenericDataView>
