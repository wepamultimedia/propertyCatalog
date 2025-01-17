<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "types",
        bc: [
            {
                label: "types",
            }
        ]
    }, () => page)
};
</script>
<script setup>
import {Link, router} from "@inertiajs/vue3";
import Table from "@core/Components/Table.vue";

const props = defineProps(["types"]);

</script>
<template>
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden my-6">
        <span class="text-skin-base  font-medium text-xl">{{ __("types_list") }}</span>
        <Link :href="route('admin.property_catalog.types.create')"
              as="button"
              class="btn btn-success text-sm"
              type="button">{{ __("create") }}
        </Link>
    </div>
    <div class="w-full
                    bg-white dark:bg-gray-700
                    overflow-hidden
                    shadow
                    text-skin-base
                    rounded-lg
                    mb-20">
        <Table :columns="['name']"
               :data="types"
               delete-route="admin.property_catalog.types.destroy"
               divide-x
               edit-route="admin.property_catalog.types.edit"
               even
               search-route="admin.property_catalog.types.index">
        </Table>
    </div>
</template>
<style lang="scss"
       scoped></style>
