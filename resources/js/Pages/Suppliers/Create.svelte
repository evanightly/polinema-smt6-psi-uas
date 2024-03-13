<script>
    import axios from 'axios';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import { router } from '@inertiajs/svelte';
    import { showConfirmDialog, showSuccessDialog } from '../../Helpers/showDialog';

    let newSupplierData = {
        name: '',
        address: '',
        email: '',
        phone: '',
        note: '',
    };

    async function handleSubmit() {
        const result = await showConfirmDialog();

        try {
            if (result.isConfirmed) {
                await axios.post('/api/suppliers', newSupplierData);
                await showSuccessDialog('Supplier added successfully');
                router.visit('/suppliers');
            } else {
                await showDeclinedDialog('Supplier addition declined');
            }
        } catch (error) {}
    }
</script>

<DashboardLayout title="Add Supplier">
    <div class="flex flex-col gap-5">
        <form on:submit|preventDefault={handleSubmit} class="flex flex-col gap-5">
            <div class="rounded-lg bg-backgroundSecondary p-8 gap-5 flex flex-col">
                <div class="text-xl">Supplier Information</div>

                <div class="form-group">
                    <div class="form-field">
                        <label class="label" for="name">Name</label>
                        <input
                            type="text"
                            class="input input-bordered input-block"
                            id="name"
                            bind:value={newSupplierData.name}
                            required
                        />
                    </div>
                    <div>
                        <label class="label" for="address">Address</label>
                        <input
                            type="text"
                            class="input input-bordered input-block"
                            id="address"
                            bind:value={newSupplierData.address}
                            required
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="email">Email</label>
                        <input
                            type="email"
                            class="input input-bordered input-block"
                            id="email"
                            bind:value={newSupplierData.email}
                            required
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="phone">Phone</label>
                        <input
                            type="text"
                            class="input input-bordered input-block"
                            id="phone"
                            bind:value={newSupplierData.phone}
                            required
                        />
                    </div>
                    <div class="form-field">
                        <label class="label" for="note">Note</label>
                        <textarea
                            class="textarea textarea-bordered textarea-block"
                            id="note"
                            bind:value={newSupplierData.note}
                        ></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-fit">Add Supplier</button>
        </form>
    </div>
</DashboardLayout>
