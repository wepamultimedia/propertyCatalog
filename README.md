# Property Catalog

Este paquete contiene las funciones de un catálogo de propiedades.


## Installation (Required)

### Install
```
php artisan property-catalog:install
```

### NPM dependencies (Required)

```
npm install @ckeditor/ckeditor5-vue
npm install wepa-ckeditor5-filemanager

npm i -D @ckeditor/ckeditor5-vue wepa-ckeditor5-filemanager
```

### Vendor Publish
```
// The web site report issues 
php artisan vendor:publish --tag=property-catalog
```

##### Vendor tags:

`property-catalog, property-catalog-js, property-catalog-lang, property-catalog-config`

[property-catalog]: incluye todos los tags | Include all tags

## Using this package

### JS

Puede personalizar las vistas en la ruta

You can customize the views on the route

`resources/js/Pages/PropertyCatalog`

##### otros archivos js | another js files

`resources/js/PropertyCatalog`

### Views

`resources/views/Vendor/PropertyCatalog`

## Uninstall
```
php artisan property-catalog:uninstall
```
