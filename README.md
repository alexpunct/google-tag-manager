# Google Tag Manager for Magento

Fully featured Google Tag Manager extension for Magento CE. 

Current module version: 1.0.0
Tested on Magento Community Edition 1.x. 

### 1. Features

* GTM script embedded in all pages

* dataLayer implementation:
	* Magento context sent via dataLayer (default *disabled*):
	* Category Page data (default *disabled*)
	* Product Page data (default *disabled*)
	* Order Success page (default ***enabled***)
	
A demo of the module implemented can be found here: http://sandbox.bitloop.co.uk. You can inspect the page using firebug and search for `Google Tag Manager`.
	
### 2. Installation

Just clone the repo or download the files, then add them to your Magento installation, relative to the Magento root folder.

Example:
- Magento root folder is `/var/www/html`
- The `app` folder will become `/var/www/html/app`

### 3. Configuration

The configuration is located in `System > Configuration > BitLoop > Google Tag Manager`.

##### 3.1 General Configuration

* Enabled (default No)
Whether to enable Google Tag Manager on your website/store

* Container ID
Your Google Tag Manager Container ID. Provided by Google when you create a new container inside GTM. Recommended is to have one container even if you have multiple domains.

##### 3.2 Data Layer Configuration

* Send Magento Context data (default No)
When set to Yes, it sends to GTM custom parameters about each page view that you can capture, analyse or use them as triggers in GTM. The variables are explained below:

	* magentoModule - the request module name (example: `catalog` for product and category pages, `checkout` for cart and checkout, `cms` for homepage or other CMS pages)
	* magentoController - the request controller name (example: `product` for product pages, `category` for category pages, `cart` for cart, `onepage` for one page checkout, `index` for homepage)
	* magentoAction - the request action name (example: `view` for products and categories, `index` for cart and one page checkout, `index` for homepage)
	* customerGroupId - the Customer Group Id (example: `0` for Not Logged In customers, `1` for Logged in customers in the General group). The groups can be found and modified in `Customers > Customer Groups` in admin
	* storeCode - the current Store Code (example: `default`)
	* storeId - the current Store Id (example: `1`)
	* locale - the locale code for the current store (example: `en_GB`)

* Category page data (default No)
Send to GTM the data associated with the current category when on a category page:

	* categoryId - the category id (example: `10`)
	* categoryName - category name (example: `Accessories`)
	* categoryIsAnchor - whether is an anchor category (example: `1` or `0`). An anchor category is one that has enabled the left column with the category filters
	* categoryProductsCount - number of products in the category (example: `20`)
	* categoryCmsBlockId - the CMS block associated to the category, if any. Each category can be set to display only products or a CMS block and products or only a CMS block (example: `7`)
	* categoryDisplayMode - the category display mode (example: `PRODUCTS` for products only, `PAGE` for CMS block only or `PRODUCTS_AND_PAGE` for both CMS blocks and products)
	* pageCategory - current section (hardcoded to `category`). You can also use this to filter only category pages in GTM
	
* Product page data (default No)
Send to GTM the data associated with the current product when on a product page:

	* productId - the product id (example: `111`)
	* productSku - the product unique identifier for your business, known as **SKU** (example: `abc-123`)
	* productName - the product name (Example: `Retro chic eyeglasses`)
	* productType - the product type id (Example: `simple` or `configurable` or `bundle` or `downloadable`)
	* productInStock - whether the product is in stock (example: `0` or `1`)
	* productPrice - the product price (example: `295.0000`)
	* productSpecialPrice - the product special price, if exists (example: `250.0000`). You can use this to identify if a product is on discount.
	* pageCategory - current section (hardcoded to `product`). You can also use this to filter only product pages in GTM 
	
* Order Success page (default Yes). 
Send to GTM transaction data once the order has been placed. **This IS compatible with Google Analytics Ecommerce tracking.**

	* transactionId - the Magento order increment id (example: `145000018`)
	* transactionAffiliation - the store id where the order was placed (example: `1`)
	* transactionTotal - the order grand total in the currency it was placed (example: `383.0900`)
	* transactionProducts - the list of products in the order as array (example: `[{"name":"Retro Chic Eyeglasses","sku":"ace002","category":"","price":"295.0000","quantity":"1.0000"}]`)
	* transactionShipping - the shipping amount (example: `88.0900`)
	* transactionTax - the transaction tax amount (example: `10.0000`)
	* transactionCurrency - the currency the transaction was placed in (example: `GBP`)
	* pageCategory - current section (hardcoded to `new_order`). You can also use this to filter only the order success page in GTM
	
### 4. License, Contributions and Support

This module is free to use and modify as you please. 
If you want to contribute to this project, please email support.
If you have any special requests or you need custom configuration or installation please email support.

Any support issues can be submitted to support@bitloop.co.uk.

### 5. Upcoming features

* Ability to choose in the config which fields you send individually

* Load the fields from the configuration to make it easier to add new sections/fields

* New sections and fields to pass more data to GTM

* Events integration

* Support for Magento Enterprise Full Page Cache