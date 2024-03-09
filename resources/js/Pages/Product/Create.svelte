<script>
    import { onMount } from 'svelte';
    import { debounce } from 'lodash';
    import axios from 'axios';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    let supplierData = {};
    let searchSupplier = '';

    const debouncedFetchSuppliers = debounce(fetchSuppliers, 300);

    async function fetchSuppliers() {
        const { data: response } = await axios.get(
            `/api/suppliers?search=${searchSupplier}`,
        );
        supplierData = response;
        console.log(response);
    }

    $: supplierTotal = supplierData.meta?.total ?? 0;

    $: showedSupplierTotal = supplierData.data?.length ?? 0;

    $: searchSupplier, debouncedFetchSuppliers();

    onMount(fetchSuppliers);
</script>

<DashboardLayout title="Add Product">
    <div class="flex flex-col gap-5 mt-5">
        <form>
            <div class="divider">Product Information</div>

            <div class="form-group">
                <div class="form-field">
                    <label class="label" for="name">Name</label>
                    <input
                        type="text"
                        class="input input-bordered input-block"
                        id="name"
                    />
                </div>
                <div>
                    <label class="label" for="price">Price (Rp)</label>
                    <input
                        type="number"
                        class="input input-bordered input-block"
                        id="price"
                    />
                </div>
                <div class="form-field">
                    <label class="label" for="description">Description</label>
                    <textarea
                        class="textarea textarea-bordered textarea-block"
                        id="description"
                    ></textarea>
                </div>
                <div class="flex">
                    <div class="form-field flex flex-1">
                        <label class="label" for="image">Product Image</label>
                        <input
                            type="file"
                            class="input-file w-full"
                            id="image"
                        />
                    </div>
                    <div class="form-group flex flex-1">
                        <label class="label" for="supplier">Supplier</label>
                        <div
                            class="flex flex-col w-fit rounded-lg border-2 border-gray-6"
                        >
                            <input
                                type="text"
                                class="input border-none border-b"
                                placeholder="Search Supplier"
                                bind:value={searchSupplier}
                            />

                            <div class="divider">
                                <span>
                                    Found: {supplierTotal} (Showed: {showedSupplierTotal})
                                </span>
                            </div>

                            <select class="select border-none" id="supplier">
                                {#each supplierData?.data ?? [] as supplier (supplier.id)}
                                    <option value={supplier.id}>
                                        {supplier.name}
                                    </option>
                                {/each}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider">Stock Management</div>

            <div class="form-group grid grid-cols-2">
                <div class="form-field">
                    <label class="label" for="stock">Stock</label>
                    <input
                        type="number"
                        class="input input-bordered input-block"
                        id="stock"
                    />
                </div>
                <div class="form-field">
                    <label class="label" for="restock_threshold">
                        Restock Threshold (%)
                    </label>
                    <input
                        type="number"
                        class="input input-bordered input-block"
                        id="restock_threshold"
                    />
                </div>
                <div class="form-field">
                    <label class="label" for="min_stock">Min Stock</label>
                    <input
                        type="number"
                        class="input input-bordered input-block"
                        id="min_stock"
                    />
                </div>
                <div class="form-field">
                    <label class="label" for="max_stock">Max Stock</label>
                    <input
                        type="number"
                        class="input input-bordered input-block"
                        id="max_stock"
                    />
                </div>
            </div>

            <div class="mt-5">
                <button class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</DashboardLayout>
