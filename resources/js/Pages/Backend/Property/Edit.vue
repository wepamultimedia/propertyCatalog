<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "properties",
        bc: [
            {
                label: "properties",
                route: "admin.property_catalog.properties.index"
            }, {label: "edit"}
        ]
    }, () => page)
};
</script>
<script setup>
import {computed, reactive, ref} from "vue";
import Table from "@core/Components/Table.vue";
import Ckeditor from "@core/Components/Form/Ckeditor.vue";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import InputImage from "@core/Components/Form/InputImage.vue";
import InputFile from "@core/Components/Form/InputFile.vue";
import Select from "@core/Components/Select.vue";
import Input from "@core/Components/Form/Input.vue";
import Textarea from "@core/Components/Form/Textarea.vue";
import SaveFormButton from "@core/Components/Form/SaveFormButton.vue";
import SeoForm from "@core/Components/Backend/SeoForm.vue";
import {__} from "@core/Mixins/translations";
import {router, useForm, usePage} from "@inertiajs/vue3";
import Icon from "@core/Components/Heroicon.vue";
import Flap from "@core/Components/Flap.vue";
import {useStore} from "vuex";

const props = defineProps(["property", "categories", "images", "files", "prices", "errors", "routePrefix"]);

const values = reactive({
    name: null,
    summary: null,
    cover: null,
    cover_alt: null,
    cover_title: null
});
const selectedLocale = ref();
const store = useStore();
const form = useForm({
    ...props.property.data
});

const propertyFiles = reactive({
    flap: false,
    add: file => {
        propertyFiles.form.file_url = file.url;
        propertyFiles.form.name = file.name;
        propertyFiles.form.property_id = form.id;
        propertyFiles.form.post(route("admin.property_catalog.files.store"), {
            preserveState: true,
            preserveScroll: true,
            onFinish: () => {
                propertyFiles.close();
            }
        });
    },
    close: () => {
        propertyFiles.flap = false;
        propertyFiles.form.reset();
    },
    position: (file, position) => {
        router.put(route("admin.property_catalog.files.position", {
            file: file.id,
            position: position
        }), {}, {
            preserveState: true,
            preserveScroll: true
        });
    },
    form: useForm({
        id: null,
        property_id: null,
        file_url: null,
        name: null,
        translations: {}
    })
});

const propertyImages = reactive({
    flap: false,
    add: image => {
        propertyImages.form.image_url = image.url;
        propertyImages.form.image_alt = image.alt_name;
        propertyImages.form.property_id = form.id;
        propertyImages.form.post(route("admin.property_catalog.images.store"), {
            preserveState: true,
            preserveScroll: true,
            onFinish: () => {
                propertyImages.close();
            }
        });
    },
    edit: (image) => {
        propertyImages.form.id = image.id;
        propertyImages.form.property_id = image.property_id;
        propertyImages.form.image_url = image.image_url;
        propertyImages.form.translations = image.translations;
        propertyImages.flap = true;
    },
    update: () => {
        propertyImages.form.put(route("admin.property_catalog.images.update", {image: propertyImages.form.id}), {
            preserveState: true,
            preserveScroll: true,
            onFinish: () => {
                propertyImages.close();
            }
        });
    },
    close: () => {
        propertyImages.flap = false;
        propertyImages.form.reset();
    },
    position: (image, position) => {
        router.put(route("admin.property_catalog.images.position", {
            image: image.id,
            position: position
        }), {}, {
            preserveState: true,
            preserveScroll: true
        });
    },
    form: useForm({
        id: null,
        property_id: null,
        image_url: null,
        image_alt: null,
        translations: {}
    })
});
const pricesForm = reactive({
    flap: false,
    type: "",
    store: () => {
        pricesForm.form.post(route("admin.property_catalog.prices.store"), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                pricesForm.close();
            }
        });
    },
    update: () => {
        pricesForm.form.put(route("admin.property_catalog.prices.update", {price: pricesForm.form.id}), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                pricesForm.close();
            }
        });
    },
    create: () => {
        pricesForm.flap = true;
        pricesForm.type = "create";
    },
    edit: price => {
        pricesForm.form.id = price.id;
        pricesForm.form.price = price.price;
        pricesForm.form.translations = price.translations;

        pricesForm.flap = true;
        pricesForm.type = "edit";
    },
    reset: () => {
        pricesForm.type = "";
        pricesForm.form.id = null;
        pricesForm.form.price = null;
        pricesForm.form.translations = {};
    },
    close: () => {
        pricesForm.flap = false;
        pricesForm.type = null;
        pricesForm.reset();
    },
    form: useForm({
        id: null,
        property_id: form.id,
        price: null,
        translations: {}
    })
});

const submit = () => {
    form.put(route("admin.property_catalog.properties.update", {property: form.id}), {
        onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
        onError: () => store.dispatch("backend/addAlert", {type: "error", message: form.errors})
    });
};

const categorySlug = computed(() => {
    if (form.category_id) {
        const category = props.categories.data.find(category => {
            return category.id === form.category_id;
        });

        const typeName = category.type.translations[store.getters["backend/formLocale"]].name;
        const categoryName = category.translations[store.getters["backend/formLocale"]].name;

        return `${typeName}/${categoryName}/${values.name ? values.name : ""}`.toLowerCase();
    }

    return "";
});
</script>
<template>
    <!--Title-->
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-4">
        <span class="dark:text-light font-medium text-xl">{{ __("edit_title") }}</span>
    </div>
    <form class="pb-8"
          @submit.prevent="submit">
        <section class="text-skin-base
                    border
                    dark:border-gray-600
                    bg-white dark:bg-gray-600
                    rounded-lg
                    shadow">
            <div class="grid grid-cols-12 divide-y xl:divide-x xl:divide-y-0 divide-gray-300 dark:divide-gray-700">
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
                        <div class="mb-6 grid grid-cols-3">
                            <div>
                                <label class="text-sm">{{ __("published") }}</label>
                                <ToggleButton v-model="form.published"/>
                            </div>
                            <div>
                                <label class="text-sm">{{ __("highlighted") }}</label>
                                <ToggleButton v-model="form.highlighted"/>
                            </div>
                            <div>
                                <label class="text-sm">{{ __("airbnb") }}</label>
                                <ToggleButton v-model="form.airbnb"/>
                            </div>
                        </div>
                        <div class="mb-6 grid grid-cols-3">
                            <div>
                                <label class="text-sm">{{ __("new") }}</label>
                                <ToggleButton v-model="form.new"/>
                            </div>
                            <div>
                                <label class="text-sm">{{ __("latest") }}</label>
                                <ToggleButton v-model="form.latest"/>
                            </div>
                            <div>
                                <label class="text-sm">{{ __("sold") }}</label>
                                <ToggleButton v-model="form.sold"/>
                            </div>
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
                        <div class="mb-6">
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
                                        v-model:alt_name="values.cover_alt"
                                        v-model:title="values.cover_title"
                                        v-model:url="values.cover"
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
        </section>
    </form>
    <!-- Prices -->
    <section class="my-8">
        <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-6">
            <span class="text-skin-base font-medium text-lg">{{ __("prices") }}</span>
            <button class="btn btn-secondary"
                    @click="pricesForm.create">{{ __("add_price") }}
            </button>
        </div>
        <div class="text-skin-base
                    border
                    overflow-hidden
                    dark:border-gray-600
                    bg-white dark:bg-gray-600
                    rounded-lg
                    shadow">
            <Table :columns="['name', 'price', 'position']"
                   :data="prices.data"
                   :delete-message="__('delete_price_message')"
                   :delete-title="__('delete_price_title')"
                   delete-route="admin.property_catalog.prices.destroy"
                   divide-x
                   edit-route="admin.property_catalog.prices.edit"
                   even>
                <template #col-content-position="{item}">
                    <div class="flex items-center justify-start">
                        <div class="inline-flex"
                             role="group">
                            <button class="rounded-l-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                    type="button"
                                    @click="propertyImages.position(item, item.position - 1)">
                                <Icon class="m-0 fill-white h-4 w-4"
                                      icon="chevron-up"></Icon>
                            </button>
                            <span class="px-2 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase"
                                  type="button">
                                {{ item.position }}
                            </span>
                            <button class="rounded-r-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                    type="button"
                                    @click="propertyImages.position(item, item.position + 1)">
                                <Icon class="m-0 fill-white h-4 w-4"
                                      icon="chevron-down"></Icon>
                            </button>
                        </div>
                    </div>
                </template>
                <template #action-edit="{item}">
                    <button class="w-8 h-6"
                            @click="pricesForm.edit(item)">
                        <icon class="fill-skin-base w-5 h-5"
                              icon="pencil-alt"></icon>
                    </button>
                </template>
            </Table>
        </div>
    </section>
    <!-- Property Files -->
    <section class="my-8">
        <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-6">
            <span class="text-skin-base font-medium text-lg">{{ __("files") }}</span>
            <InputFile :button-label="__('add_file')"
                       button-class="btn btn-secondary"
                       class="flex justify-end"
                       name="cover"
                       @change="propertyFiles.add"/>
        </div>
        <div class="text-skin-base
                    border
                    overflow-hidden
                    dark:border-gray-600
                    bg-white dark:bg-gray-600
                    rounded-lg
                    shadow">
            <Table :columns="['name']"
                   :data="files"
                   :delete-message="__('delete_file_message')"
                   :delete-title="__('delete_file_title')"
                   delete-route="admin.property_catalog.files.destroy"
                   divide-x
                   even>
            </Table>
        </div>
    </section>
    <!-- Property Images -->
    <section class="my-8">
        <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-6">
            <span class="text-skin-base font-medium text-lg">{{ __("image_gallery") }}</span>
            <InputImage :button-label="__('add_image')"
                        :show-image="false"
                        button-class="btn btn-secondary"
                        class="flex justify-end"
                        name="cover"
                        @change="propertyImages.add"/>
        </div>
        <div class="text-skin-base
                    border
                    overflow-hidden
                    dark:border-gray-600
                    bg-white dark:bg-gray-600
                    rounded-lg
                    shadow">
            <Table :columns="['image_url', 'image_alt', 'position']"
                   :data="images"
                   :delete-message="__('delete_image_message')"
                   :delete-title="__('delete_image_title')"
                   delete-route="admin.property_catalog.images.destroy"
                   divide-x
                   edit-route="admin.property_catalog.images.edit"
                   even>
                <template #col-content-image_url="{item}">
                    <figure>
                        <img :alt="item.image_alt"
                             :src="item.image_url"
                             class="w-20 h-20 object-cover aspect-square">
                    </figure>
                </template>
                <template #col-content-position="{item}">
                    <div class="flex items-center justify-start">
                        <div class="inline-flex"
                             role="group">
                            <button class="rounded-l-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                    type="button"
                                    @click="propertyImages.position(item, item.position - 1)">
                                <Icon class="m-0 fill-white h-4 w-4"
                                      icon="chevron-up"></Icon>
                            </button>
                            <span class="px-2 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase"
                                  type="button">
                                {{ item.position }}
                            </span>
                            <button class="rounded-r-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                    type="button"
                                    @click="propertyImages.position(item, item.position + 1)">
                                <Icon class="m-0 fill-white h-4 w-4"
                                      icon="chevron-down"></Icon>
                            </button>
                        </div>
                    </div>
                </template>
                <template #action-edit="{item}">
                    <button class="w-8 h-6"
                            @click="propertyImages.edit(item)">
                        <icon class="fill-skin-base w-5 h-5"
                              icon="pencil-alt"></icon>
                    </button>
                </template>
            </Table>
        </div>
    </section>
    <!-- seo -->
    <section class="my-8">
        <h2 class="font mb-4">{{ __("seo") }}</h2>
        <SeoForm v-model:seo="form.seo"
                 :description="values.summary"
                 :errors="errors?.seo"
                 :image="values.cover"
                 :image-alt="values.cover_alt"
                 :image-title="values.cover_title"
                 :slug="categorySlug"
                 :slug-prefix="routePrefix"
                 :title="values.name"
                 article-type="blog_entry"
                 page-type="article"/>
    </section>
    <!-- Prices flap -->
    <Flap v-model="pricesForm.flap"
          :on-close="pricesForm.close"
          close-background
          md>
        <form v-if="pricesForm.type === 'create'"
              class="pb-8"
              @submit.prevent="pricesForm.store">
            <h2>{{ __("add_price") }}</h2>
            <div class="my-6">
                <Input v-model="pricesForm.form"
                       v-model:locale="selectedLocale"
                       :errors="errors"
                       :label="__('name')"
                       autofocus
                       name="name"
                       required
                       translation/>
            </div>
            <div class="my-6">
                <Input v-model="pricesForm.form"
                       v-model:locale="selectedLocale"
                       :errors="errors"
                       :label="__('price')"
                       name="price"
                       required/>
            </div>
            <div class="rounded-b-lg ">
                <SaveFormButton :form="pricesForm.form"/>
            </div>
        </form>
        <form v-if="pricesForm.type === 'edit'"
              class="pb-8"
              @submit.prevent="pricesForm.update">
            <h2>{{ __("edit_price") }}</h2>
            <div class="my-6">
                <Input v-model="pricesForm.form"
                       v-model:locale="selectedLocale"
                       :errors="errors"
                       :label="__('name')"
                       autofocus
                       name="name"
                       required
                       translation/>
            </div>
            <div class="my-6">
                <Input v-model="pricesForm.form"
                       v-model:locale="selectedLocale"
                       :errors="errors"
                       :label="__('price')"
                       name="price"
                       required/>
            </div>
            <div class="rounded-b-lg ">
                <SaveFormButton :form="pricesForm.form"/>
            </div>
        </form>
    </Flap>

    <!-- Property images flap -->
    <Flap v-model="propertyImages.flap"
          :on-close="propertyImages.close"
          close-background
          md>
        <form class="pb-8"
              @submit.prevent="propertyImages.update">
            <figure>
                <img :src="propertyImages.form.image_url"
                     alt=""
                     class="w-full">
            </figure>
            <div class="my-6">
                <Input v-model="propertyImages.form"
                       v-model:locale="selectedLocale"
                       :errors="errors"
                       :label="__('image_alt')"
                       autofocus
                       name="image_alt"
                       required
                       translation/>
            </div>
            <div class="rounded-b-lg ">
                <SaveFormButton :form="propertyImages.form"/>
            </div>
        </form>
    </Flap>
</template>
<style>
.ck-editor__editable {
    @apply min-h-[260px] max-h-[800px]
}
</style>
