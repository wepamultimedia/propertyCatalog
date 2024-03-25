<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "properties",
        bc: [
            {
                label: "categories",
                route: "admin.property_catalog.properties.index"
            }, {label: "edit"}
        ]
    }, () => page)
};
</script>
<script setup>
import { reactive, ref } from "vue";
import Input from "@/Vendor/Core/Components/Form/Input.vue";
import Textarea from "@/Vendor/Core/Components/Form/Textarea.vue";
import SaveFormButton from "@/Vendor/Core/Components/Form/SaveFormButton.vue";
import SeoForm from "@core/Components/Backend/SeoForm.vue";
import { __ } from "@/Vendor/Core/Mixins/translations";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import { useForm } from "@inertiajs/vue3";
import { useStore } from "vuex";

const props = defineProps({
    category: Object,
    errors: Object
});

const inputValues = reactive({
    name: null,
    description: null
});
const selectedLocale = ref();

const store = useStore();

const form = useForm({
    translations: {},
    ...props.category.data
});

const submit = () => {
    form.put(route("admin.property_catalog.categories.update", {category: props.category.data.id}), {
        onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
        onError: () => store.dispatch("backend/addAlert", {type: "error", message: form.errors})
    });
};
</script>
<template>
    <!--Title-->
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-4">
        <span class="dark:text-light font-medium text-xl">{{ __("edit_title") }}</span>
    </div>
    <form @submit.prevent="submit">
        <div class="max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 text-skin-base ">
                <div class="col-span-1">
                    <p class="text-sm"
                       v-html="__('edit_summary')"></p>
                </div>
                <div class="col-span-2
                        border
                        dark:border-gray-600
                        bg-white dark:bg-gray-600
                        rounded-lg
                        shadow">
                    <div class="grid grid-cols-6 p-6">
                        <div class="col-span-6 sm:col-span-6 lg:col-span-5 xl:col-span-4 mb-6">
                            <ToggleButton v-model="form.published" :key="form.id + '-component'" :label="__('published')"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6 lg:col-span-5 xl:col-span-4 mb-6">
                            <Input v-model="form"
                                   v-model:locale="selectedLocale"
                                   v-model:value="inputValues.name"
                                   :errors="form.errors"
                                   :label="__('name')"
                                   autofocus
                                   name="name"
                                   translation/>
                        </div>
                        <div class="col-span-6 mb-6">
                            <Textarea v-model="form"
                                      v-model:locale="selectedLocale"
                                      v-model:value="inputValues.description"
                                      :errors="form.errors"
                                      :label="__('description')"
                                      name="description"
                                      translation/>
                        </div>
                    </div>
                    <div class="rounded-b-lg overflow-hidden">
                        <div class="p-3 bg-gray-200 dark:bg-gray-500 flex justify-end">
                            <SaveFormButton :form="form"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-skin-base  my-8">
            <SeoForm v-model:locale="selectedLocale"
                     v-model:seo="form.seo"
                     :description="inputValues.description"
                     :title="inputValues.name"/>
        </div>
    </form>
</template>
<style lang="scss"
       scoped></style>
