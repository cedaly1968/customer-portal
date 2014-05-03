DROP TABLE IF EXISTS product_shipping;
CREATE TABLE product_shipping(
	id INT(11) NOT NULL AUTO_INCREMENT,
	productid INT(11) NOT NULL,
	shippingid INT(11) NOT NULL,
	PRIMARY KEY(id)
);

DROP TABLE IF EXISTS product_shipping_config;
CREATE TABLE product_shipping_config(
	name VARCHAR(32) NOT NULL,
	value VARCHAR(32) NOT NULL,
	PRIMARY KEY(name)
);

INSERT INTO product_shipping_config VALUES ('product_shipping','N');

REPLACE INTO xcart_languages VALUES ('en','txt_shipping_per_product_top_text','Use this tool to mass add shipping methods to a group of products.  First select a category of products, then you can use the Ctrl key to select multiple products and shipping methods.<BR><BR><B>NOTE:</b> We recommend that you have at least 1 shipping method available to every product.','Text');
REPLACE INTO xcart_languages VALUES ('en','lbl_add_shipping','Add Shipping','Labels');
REPLACE INTO xcart_languages VALUES ('en','lbl_add_shipping_for_all_products','Add Shipping For All Products','Labels');
REPLACE INTO xcart_languages VALUES ('en','txt_delete_previous_methods','&nbsp;Delete all the existing product shipping methods before adding the new ones.','Text');
REPLACE INTO xcart_languages VALUES ('en','txt_all_shipping_confirm','Are you sure you want to modify the shipping methods for all the products?','Text');
REPLACE INTO xcart_languages VALUES ('en','txt_all_shipping_updated','The shipping methods for all the products have been updated.','Text');
REPLACE INTO xcart_languages VALUES ('en','lbl_shipping_per_product','Shipping Per Product','Labels');
REPLACE INTO xcart_languages VALUES ('en','lbl_change_shipping','Change Shipping Methods','Labels');
