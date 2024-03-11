<script>
    import { onMount } from 'svelte';
    import { debounce } from 'lodash';
    import axios from 'axios';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import loading from '../../Stores/loadingOverlayStore';
    import { router } from '@inertiajs/svelte';
    import { showConfirmDialog, showSuccessDialog } from '../../Helpers/showDialog';

    let imageFile;
    let supplierData = {};
    let searchSupplier = '';

    const debouncedFetchSuppliers = debounce(fetchSuppliers, 300);

    function handleFileChange(event) {
        imageFile = event.target.files[0];
    }

    async function fetchSuppliers() {
        const { data: response } = await axios.get(`/api/suppliers?search=${searchSupplier}`);
        supplierData = response;
    }

    $: supplierTotal = supplierData.meta?.total ?? 0;

    $: showedSupplierTotal = supplierData.data?.length ?? 0;

    $: searchSupplier, debouncedFetchSuppliers();

    onMount(fetchSuppliers);

    const defaultNewProductData = {
        name: '',
        price: '',
        description: '',
        image: '',
        stock: '',
        supplier_id: '',
        min_stock: '',
        restock_threshold: '50',
        max_stock: '',
    };

    let newProductData = defaultNewProductData;

    async function handleSubmit() {
        const result = await showConfirmDialog('Are you sure?', "You won't be able to revert this!");

        console.log(result);

        if (result.isConfirmed) {
            loading.start('Saving product');

            const formData = new FormData();
            Object.entries(newProductData).forEach(([key, value]) => {
                formData.append(key, value);
            });
            if (imageFile) {
                formData.append('image', imageFile);
            }

            const url = '/api/products';
            const options = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                // onUploadProgress: progressEvent => {
                //     console.log(progressEvent);
                // },
            };

            await axios.post(url, formData, options);

            loading.stop();

            showSuccessDialog('Product has been added');

            router.visit('/products');
        }
    }
</script>

<DashboardLayout title="Add Product">
    <div class="flex flex-col gap-5">
        <form on:submit|preventDefault={handleSubmit} class="flex flex-col gap-5">
            <div class="rounded-lg bg-backgroundSecondary p-8 gap-5 flex flex-col">
                <div class="text-xl">Product Information</div>

                <div class="form-group">
                    <div class="form-field">
                        <label class="label" for="name">Name</label>
                        <input
                            type="text"
                            class="input input-bordered input-block"
                            id="name"
                            bind:value={newProductData.name}
                            required
                        />
                    </div>
                    <div>
                        <label class="label" for="price">Price (Rp)</label>
                        <input
                            type="number"
                            class="input input-bordered input-block"
                            id="price"
                            bind:value={newProductData.price}
                            required
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="description">Description</label>
                        <textarea
                            class="textarea textarea-bordered textarea-block"
                            id="description"
                            bind:value={newProductData.description}
                        ></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-5">
                        <div class="form-field flex flex-1">
                            <label class="label" for="image">Product Image</label>
                            <input type="file" class="input-file max-w-full" id="image" on:change={handleFileChange} />
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-backgroundSecondary p-8 gap-5 flex flex-col">
                <div class="text-xl">Stock Management</div>

                <div class="form-group grid grid-cols-1 lg:grid-cols-2">
                    <div class="form-field">
                        <label class="label" for="stock">Stock</label>
                        <input
                            type="number"
                            class="input input-bordered input-block"
                            id="stock"
                            bind:value={newProductData.stock}
                            required
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="restock_threshold"> Restock Threshold (%) </label>
                        <input
                            type="number"
                            class="input input-bordered input-block"
                            id="restock_threshold"
                            bind:value={newProductData.restock_threshold}
                            required
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="min_stock">
                            Min Stock

                            <span
                                class="tooltip tooltip-right"
                                data-tooltip="This will take precedence over restock threshold"
                            >
                                <button type="button">
                                    <i class="ri-question-mark"></i>
                                </button>
                            </span>
                        </label>

                        <input
                            type="number"
                            class="input input-bordered input-block"
                            id="min_stock"
                            bind:value={newProductData.min_stock}
                            required
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="max_stock">Max Stock</label>
                        <input
                            type="number"
                            class="input input-bordered input-block"
                            id="max_stock"
                            bind:value={newProductData.max_stock}
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-backgroundSecondary p-8 gap-5 flex flex-col">
                <div class="text-xl">Supplier</div>

                <div class="form-group flex flex-1">
                    <label class="label" for="supplier">Supplier</label>
                    <div class="flex flex-col rounded-lg border-2 border-gray-6">
                        <input
                            type="text"
                            class="input input-block border-none border-b"
                            placeholder="Search Supplier"
                            bind:value={searchSupplier}
                        />

                        <div class="divider">
                            <span>
                                Found: {supplierTotal} (Showed: {showedSupplierTotal})
                            </span>
                        </div>

                        <select
                            class="select select-block border-none"
                            id="supplier"
                            bind:value={newProductData.supplier_id}
                            required
                        >
                            {#each supplierData?.data ?? [] as supplier (supplier.id)}
                                <option value={supplier.id}>
                                    {supplier.name}
                                </option>
                            {/each}
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-fit">Add Product</button>
        </form>
    </div>
</DashboardLayout>
