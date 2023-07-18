<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "properties",
        bc: [
            {
                label: "properties",
                route: "admin.property_catalog.properties.index"
            }, {label: "create"}
        ]
    }, () => page)
};
</script>
<script setup>
import { reactive, ref } from "vue";
import Ckeditor from "@core/Components/Form/Ckeditor.vue";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import InputImage from "@core/Components/Form/InputImage.vue";
import Select from "@core/Components/Select.vue";
import Input from "@/Vendor/Core/Components/Form/Input.vue";
import Textarea from "@/Vendor/Core/Components/Form/Textarea.vue";
import SaveFormButton from "@/Vendor/Core/Components/Form/SaveFormButton.vue";
import SeoForm from "@core/Components/Backend/SeoForm.vue";
import { __ } from "@/Vendor/Core/Mixins/translations";
import { useForm } from "@inertiajs/vue3";
import { useStore } from "vuex";

const props = defineProps(["property", "categories", "errors"]);

const values = reactive({
    name: null,
    summary: null,
    cover: null,
    cover_alt: null
});
const selectedLocale = ref();
const store = useStore();
const form = useForm({
    translations: {},
    ...props.property.data
});
const submit = () => {
    form.post(route("admin.property_catalog.properties.store"), {
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
    <form class="pb-8"
          @submit.prevent="submit">
        <div class="text-skin-base
                    border
                    dark:border-gray-600
                    bg-white dark:bg-gray-600
                    rounded-lg
                    shadow">
            <div class="grid grid-cols-12 divide-y xl:divide-x divide-gray-300 dark:divide-gray-700">
                <!-- title, summary and body-->
                <div class="p-6 col-span-full xl:col-span-8">
                    <div class="mb-6">
                        <Input v-model="form"
                               v-model:locale="selectedLocale"
                               v-model:value="values.name"
                               :errors="errors"
                               :label="__('name')"
                               autofocus
                               name="name"
                               required
                               translation/>
                    </div>
                    <div class="mb-6">
                        <Textarea v-model="form"
                                  v-model:locale="selectedLocale"
                                  v-model:value="values.summary"
                                  :errors="errors"
                                  :label="__('summary')"
                                  name="summary"
                                  required
                                  translation/>
                    </div>
	                <div class="mb-6">
		                <Textarea v-model="form"
		                       :errors="errors"
		                       :label="__('address')"
		                       name="address"/>
	                </div>
	                <div class="mb-6 grid lg:grid-cols-2 gap-4">
		                <Input v-model="form"
		                       :errors="errors"
		                       :label="__('latitude')"
		                       name="latitude"/>
		                <Input v-model="form"
		                       :errors="errors"
		                       :label="__('longitude')"
		                       name="longitude"/>
	                </div>
                    <div class="mb-6">
                        <div class="mt-1"
                             style="--ck-border-radius: 0.50rem">
                            <Ckeditor v-model="form"
                                      v-model:locale="selectedLocale"
                                      :errors="errors"
                                      :label="__('data_sheet')"
                                      name="data_sheet"
                                      required
                                      translation></Ckeditor>
                        </div>
                    </div>
                </div>
                <!-- draf, date, category and cover -->
                <div class="col-span-full xl:col-span-4 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-1 divide-y lg:divide-x lg:divide-y-0 xl:divide-y xl:divide-x-0 divide-gray-300 dark:divide-gray-700 gap-4">
                    <!-- draft, date and category -->
                    <div class="p-6">
                        <div class="mb-6">
                            <label class="text-sm">{{ __("published") }}</label>
                            <ToggleButton v-model="form.published"/>
                        </div>
                        <div class="mb-6">
                            <label class="text-sm">{{ __("highlighted") }}</label>
                            <ToggleButton v-model="form.highlighted"/>
                        </div>
                        <div class="mb-6">
                            <Select v-model="form.category_id"
                                    :errors="errors"
                                    :label="__('select_category')"
                                    :options="categories.data"
                                    name="category_id"
                                    option-label="name"
                                    reduce
                                    required></Select>
                        </div>
                        <div>
                            <Input v-model="form"
                                   v-model:locale="selectedLocale"
                                   :errors="errors"
                                   :label="__('delivery')"
                                   name="delivery"
                                   translation/>
                        </div>
                    </div>
                    <!-- cover -->
                    <div class="p-6">
                        <div class="mb-6">
                            <Input v-model="form"
                                   :errors="errors"
                                   :label="__('google_earth')"
                                   name="google_earth"/>
                        </div>
                        <div class="mb-6">
                            <Input v-model="form"
                                   :errors="errors"
                                   :label="__('video_cover')"
                                   name="video_cover"/>
                        </div>
                        <div class="sm:w-1/2 lg:w-full mb-6">
                            <InputImage v-model="form.cover"
                                        v-model:alt="values.cover_alt"
                                        v-model:image="values.cover"
                                        :errors="errors"
                                        :label="__('cover_image')"
                                        name="cover"/>
                        </div>
                        <div class="mt-4">
                            <Textarea v-model="form"
                                      v-model:locale="selectedLocale"
                                      v-model:value="values.cover_alt"
                                      :errors="errors"
                                      :label="__('cover_alt')"
                                      name="cover_alt"
                                      required
                                      translation/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-b-lg overflow-hidden">
                <div class="p-3 bg-gray-200 dark:bg-gray-500 flex justify-end">
                    <SaveFormButton :form="form"/>
                </div>
            </div>
        </div>

        <!-- seo -->
        <div class="my-8">
            <h2 class="font mb-4">{{ __("seo") }}</h2>
            <SeoForm v-model:seo="form.seo"
                     :description="values.summary"
                     :errors="errors?.seo"
                     :image="values.cover"
                     :locale="selectedLocale"
                     :title="values.name"
                     article-type="blog_entry"
                     autocomplete
                     page-type="article"/>
        </div>
    </form>
</template>
<style>
.ck-editor__editable {
    @apply min-h-[260px] max-h-[800px]
}
</style>
