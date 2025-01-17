<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "categories",
        bc: [
            {
                label: "categories",
                route: "admin.property_catalog.categories.index"
            }, {label: "create"}
        ]
    }, () => page)
};
</script>
<script setup>
import {computed, reactive, ref} from "vue";
import Input from "@/Vendor/Core/Components/Form/Input.vue";
import Select from "@/Vendor/Core/Components/Select.vue";
import Textarea from "@/Vendor/Core/Components/Form/Textarea.vue";
import SaveFormButton from "@/Vendor/Core/Components/Form/SaveFormButton.vue";
import SeoForm from "@core/Components/Backend/SeoForm.vue";
import {__} from "@/Vendor/Core/Mixins/translations";
import {useForm} from "@inertiajs/vue3";
import {useStore} from "vuex";

const props = defineProps(["category", "errors", "types", "routePrefix"]);

const inputValues = reactive({
    name: null,
    description: null
});
const selectedLocale = ref();

const store = useStore();

const form = useForm({
    type_id: null,
    translations: {},
    ...props.category.data
});

const typeName = computed(() => {
    if (!form.type_id)
        return "";
    else
        return __(props.types.find(type => type.id === form.type_id).name);
});
const submit = () => {
    form.post(route("admin.property_catalog.categories.store"), {
        onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
        onError: () => store.dispatch("backend/addAlert", {type: "error", message: form.errors})
    });
};
</script>
<template>
    <!--Title-->
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-4">
        <span class="dark:text-light font-medium text-xl">{{ __("create_title") }}</span>
    </div>
    <form @submit.prevent="submit">
        <div class="max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 text-skin-base ">
                <div class="col-span-1">
                    <p class="text-sm"
                       v-html="__('create_summary')"></p>
                </div>
                <div class="col-span-2 border dark:border-gray-600 bg-white dark:bg-gray-600 rounded-lg shadow">
                    <div class="grid grid-cols-6 p-6">
                        <div class="col-span-6 sm:col-span-6 lg:col-span-5 xl:col-span-4 mb-6">
                            <Select v-model="form.type_id"
                                    :label="__('type')"
                                    :options="types.map(type => { return { id:type.id, label: type.name }})"
                                    translate-label></Select>
                        </div>
                        <div class="col-span-6 sm:col-span-6 lg:col-span-5 xl:col-span-4 mb-6">
                            <Input v-model="form"
                                   v-model:value="inputValues.name"
                                   :errors="form.errors"
                                   :label="__('name')"
                                   autofocus
                                   name="name"
                                   debug
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
                     :slug-prefix="routePrefix"
                     :slug="`${typeName}/${inputValues.name !== null ? inputValues.name : ''}`"
                     :title="`${inputValues.name}`"
                     autocomplete/>
        </div>
    </form>
</template>
<style lang="scss"
       scoped></style>
