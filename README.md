AoS MissingEdit for Magento 2
======


## Description

This feature for Magento 2 adds missing links in the admin panel.

In the admin panel there are additional product listings on configurable, grouped or bundle product edit pages. 
When we try to choose single product item for configurable, grouped or bundle product there is no way to navigate to such item.

Standard Magento 2 installation doesn't provide proper navigation in configurable, grouped or bundle product admin panel edit pages. 

This module provides missing links to item product edit pages.

Saves time for administrators while working with catalog containing several configurable, grouped or bundle products. Administrator can quickly navigate to product items.
Additionally while searching for new items such links are available in popups.

This feature adds missing [Edit] column for each configurable, grouped, bundle, related, cross-sell, up-sell product grids. After clicking [Edit] link administrator is being navigated to product edit page. 

 
##  Testing scenarios

### Configurable products

- Go to admin panel
- Go to CATALOG -> Products
- Edit configurable product
- On edit product there are configuration product items
- Each row in product items grid contains link to item edit page and edit column
- "Add Products Manually" popup grid contains links to item edit pages

### Grouped products

- Go to admin panel
- Go to CATALOG -> Products
- Edit grouped product
- On edit product there are grouped product items
- Each row in product items grid contains link to item edit page and edit column
- "Add Products to Group" popup grid contains links to item edit pages

### Bundle products

- Go to admin panel
- Go to CATALOG -> Products
- Edit bundle product
- On edit product there are bundle product option items
- Each row in option items grid contains link to item edit page
- "Add Products to Option" popup grid contains links to item edit pages

### Related products

- Go to admin panel
- Go to CATALOG -> Products
- Edit product
- On edit product there are related product items
- Each row in related items grid contains link to item edit page
- "Add Related Products" popup grid contains links to item edit pages

### Up-Sell products

- Go to admin panel
- Go to CATALOG -> Products
- Edit product
- On edit product there are up-sell product items
- Each row in up-sell items grid contains link to item edit page
- "Add Related Products" popup grid contains links to item edit pages

### Cross-Sell products

- Go to admin panel
- Go to CATALOG -> Products
- Edit product
- On edit product there are cross-sell product items
- Each row in cross-sell items grid contains link to item edit page
- "Add Related Products" popup grid contains links to item edit pages

## V1.0.0

###### Improvements

- Added missing links for configurable product items
- Added missing links for grouped product items
- Added missing links for bundle product items
- Added missing links for related product items
- Added missing links for cross-sell product items
- Added missing links for up-sell product items
- Added missing edit columns for admin panel grids
