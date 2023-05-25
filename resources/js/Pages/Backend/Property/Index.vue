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

const publish = item => {
    router.put(route("admin.property_catalog.properties.publish", {
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
		<Table :columns="['name', 'category_name', 'published', 'position']"
		       :data="properties.data"
		       delete-route="admin.property_catalog.properties.destroy"
		       divide-x
		       edit-route="admin.property_catalog.properties.edit"
		       even
		       search-route="admin.property_catalog.properties.index">
			<template #col-content-published="{item}">
				<ToggleButton :key="item.id + '-component'"
				              v-model="item.published"
				              @change="publish(item)"/>
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
