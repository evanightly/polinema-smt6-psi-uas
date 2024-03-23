<script>
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import { userStore } from '../../Stores/Data/userStore';

    let title = 'User';
    const modelUrl = 'users';
    const columns = [
        {
            key: 'name',
            label: 'Name',
        },
        {
            key: 'email',
            label: 'Email',
        },
    ];

    const store = userStore();
</script>

<GenericDataView {store} {title} {modelUrl} {columns}>
    <div slot="cardsView" let:handleDeleteItem>Not Implemented Yet</div>
</GenericDataView>
