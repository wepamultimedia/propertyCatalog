<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "properties",
        bc: [
            {
                label: "properties"
            }
        ]
    }, () => page)
};
</script>
<script setup>
import Table from "@core/Components/Table.vue";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import Icon from "@core/Components/Heroicon.vue";
import { __ } from "@/Vendor/Core/Mixins/translations";
import { Link, router, useForm } from "@inertiajs/vue3";
import { useStore } from "vuex";

const props = defineProps(["properties", "errors"]);

const store = useStore();

const form = useForm({
    name: "",
    translations: {}
});

const togglePublished = item => {
    router.put(route("admin.property_catalog.properties.update.published", {
        property: item.id,
        published: item.published ? 1 : 0,
        onError: error => {
            console.log(error);
        }
    }), {
        preserveState: true,
        preserveScroll: true
    });
};

const toggleHighlighted = item => {
    router.put(route("admin.property_catalog.properties.update.highlighted", {
        property: item.id,
        highlighted: item.highlighted ? 1 : 0,
        onError: error => {
            console.log(error);
        }
    }), {
        preserveState: true,
        preserveScroll: true
    });
};

const toggleNew = item => {
    router.put(route("admin.property_catalog.properties.update.new", {
        property: item.id,
        new: item.new ? 1 : 0,
        onError: error => {
            console.log(error);
        }
    }), {
        preserveState: true,
        preserveScroll: true
    });
};

const toggleLatest = item => {
    router.put(route("admin.property_catalog.properties.update.latest", {
        property: item.id,
        latest: item.latest ? 1 : 0,
    }), {
        preserveState: true,
        preserveScroll: true
    });
};

const toggleSold = item => {
    router.put(route("admin.property_catalog.properties.update.sold", {
        property: item.id,
        sold: item.sold ? 1 : 0
    }), {
        preserveState: true,
        preserveScroll: true
    });
};

const updatePosition = (item, position) => {
    router.put(route("admin.property_catalog.properties.position", {
        property: item.id,
        position: position
    }), {}, {
        preserveState: true,
        preserveScroll: true
    });
};
</script>
<template>
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden my-6">
        <span class="text-skin-base  font-medium text-xl">{{ __("properties_list") }}</span>
        <Link :href="route('admin.property_catalog.properties.create')"
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
        <Table :columns="['name', {name: 'category_name', show: 'lg'}, {name: 'states'}, 'position']"
               :data="properties"
               delete-route="admin.property_catalog.properties.destroy"
               divide-x
               edit-route="admin.property_catalog.properties.edit"
               even
               search-route="admin.property_catalog.properties.index">
            <template #col-content-states="{item}">
                <div class="my-1">
                    <ToggleButton :key="item.id + '-component-published'"
                                  v-model="item.published"
                                  :label="__('published')"
                                  @change="togglePublished(item)"/>
                </div>
                <div class="my-1">
                    <ToggleButton :key="item.id + '-component-highlighted'"
                                  v-model="item.highlighted"
                                  :label="__('highlighted')"
                                  @change="toggleHighlighted(item)"/>
                </div>
                <div class="my-1">
                    <ToggleButton :key="item.id + '-component-new'"
                                  v-model="item.new"
                                  :label="__('new')"
                                  @change="toggleNew(item)"/>
                </div>
                <div class="my-1">
                    <ToggleButton :key="item.id + '-component-latest'"
                                  v-model="item.latest"
                                  :label="__('latest')"
                                  @change="toggleLatest(item)"/>
                </div>
                <div class="my-1">
                    <ToggleButton :key="item.id + '-component-sold'"
                                  v-model="item.sold"
                                  :label="__('sold')"
                                  @change="toggleSold(item)"/>
                </div>

            </template>
            <template #col-content-position="{item}">
                <div class="flex items-center justify-start">
                    <div class="inline-flex"
                         role="group">
                        <button class="rounded-l-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                type="button"
                                @click="updatePosition(item, item.position + 1)">
                            <Icon class="m-0 fill-white h-4 w-4"
                                  icon="chevron-up"></Icon>
                        </button>
                        <span class="px-2 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase"
                              type="button">
                            {{ item.position }}
                        </span>
                        <button class="rounded-r-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                type="button"
                                @click="updatePosition(item, item.position - 1)">
                            <Icon class="m-0 fill-white h-4 w-4"
                                  icon="chevron-down"></Icon>
                        </button>
                    </div>
                </div>
            </template>
        </Table>
    </div>
</template>
<style lang="scss"
       scoped></style>
