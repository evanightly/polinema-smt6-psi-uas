<script>
    import { onMount } from 'svelte';
    import { debounce } from 'lodash';
    import axios from 'axios';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import formDataLogger from '../../Helpers/formDataLogger';
    import { router } from '@inertiajs/svelte';
    import loading from '../../Stores/Utility/loadingOverlayStore';
    import { showConfirmDialog, showSuccessDialog } from '../../Helpers/showDialog';

    export let product;

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
        name: product.name ?? '',
        price: product.price ?? '',
        description: product.description ?? '',
        image: '',
        stock: product.stock ?? '',
        supplier_id: product.supplier_id ?? '',
        min_stock: product.min_stock ?? '',
        restock_threshold: product.restock_threshold ?? '50',
        max_stock: product.max_stock ?? '',
        _method: 'PUT',
    };

    let newProductData = defaultNewProductData;

    async function handleSubmit() {
        const result = await showConfirmDialog();
        if (result.isConfirmed) {
            loading.start('Updating product');
            const formData = new FormData();

            Object.entries(newProductData).forEach(([key, value]) => {
                formData.append(key, value);
            });

            // formDataLogger(formData);
            if (imageFile) {
                formData.append('image', imageFile);
            }

            try {
                const response = await axios.post(`/api/products/${product.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                    // onUploadProgress: progressEvent => {
                    //     console.log(progressEvent);
                    // },
                });

                if (response.status === 200) {
                    await showSuccessDialog({ title: 'Product updated' });
                    router.visit('/products');
                }
            } catch (error) {
            } finally {
                loading.stop();
            }
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
                            min="0"
                            max={newProductData.max_stock}
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="restock_threshold">Restock Threshold (%)</label>
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
                            min="0"
                            max={newProductData.max_stock}
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
                    <label class="label" for="supplier">Current Supplier - {product.supplier.name ?? ''}</label>
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

            <button class="btn btn-secondary w-fit">Edit Product</button>
        </form>
    </div>
</DashboardLayout>
