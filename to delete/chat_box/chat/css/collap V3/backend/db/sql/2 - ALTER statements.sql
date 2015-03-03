## Author: Jessy James
## Date: 6th Jan, 2015

# ---------------------------------------- ORGANIZATION ------------------------------------#


# ---------------------------------------- CHANNELS ------------------------------------#


# ---------------------------------------- FIELD_VALIDATORS ------------------------------------#


# ---------------------------------------- DATA_FIELDS_TYPE ------------------------------------#


# ---------------------------------------- DATA_FIELDS ------------------------------------#

#Altering the datatype from int(11) to bit since value is boolean
ALTER TABLE  `data_fields` CHANGE  `is_array`  `is_array` TINYINT( 1 ) NOT NULL DEFAULT '0'
ALTER TABLE  `data_fields` CHANGE  `is_active`  `is_active` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  'Soft Deletion Flag'

## Adding a new field called 'is_active' for soft deletion
##ALTER TABLE  `data_fields` ADD  `is_active` TINYINT( 1 ) NOT NULL DEFAULT b'0' 
##COMMENT  'Soft Deletion Flag' AFTER  `default_value`


# ---------------------------------------- DATA_FIELD_VALIDATOR ------------------------------------#


# ---------------------------------------- ORG_DATA_FIELDS ------------------------------------#

#Making the name unique only within the same org and channel
ALTER TABLE  `nucleus`.`org_data_fields` DROP INDEX  `UniqueODFNameIndex` ,
ADD UNIQUE  `UniqueOrgChannelNameIndex` (  `org_data_field_name` ,  `org_id` ,  `channel_id` )

#Adding the is_required field to `org_data_field`
ALTER TABLE  `org_data_fields` ADD  `is_required` TINYINT( 1 ) NOT NULL DEFAULT '0' 
COMMENT 'Validator invalidations will not throw an exception, if this set to 0' AFTER  `channel_id`

# ---------------------------------------- ORG_DATA_FIELD_VALIDATOR ------------------------------------#


# ---------------------------------------- FIELD_VALIDATOR ------------------------------------#


# ---------------------------------------- CUSTOMER_ID_MAPPING ------------------------------------#
ALTER TABLE  `customer_id_mapping` ADD  `id` INT NOT NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY (  `id` )

ALTER TABLE  `customer_id_mapping` CHANGE  `type`  `type` ENUM(  'mobile',  'email',  
'external_id',  'facebook_id' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL

ALTER TABLE  `nucleus`.`customer_id_mapping` ADD UNIQUE  `UniqueUuidIdentifierMapping` (  `uuid` ,  `type` ,  `identifier` )


#----------------------------------------migration_requests----------------------------------------------#
ALTER TABLE `migration_requests` ADD UNIQUE (
`org_id` ,
`channel_name`
);