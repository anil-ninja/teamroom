## Author: Jessy James
## Date: 15th Dec, 2015


# ---------------------------------------- ORGANIZATION ------------------------------------#
# Altering length of `org_name` field to 50
ALTER TABLE  `nucleus`.`organization` CHANGE  `org_name`  `org_name` VARCHAR( 60 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL

# Adding UNIQUE index on org_id
ALTER TABLE  `nucleus`.`organization` ADD UNIQUE  `UniqueIntouchOrgIdIndex` (  `org_id` )

# Adding UNIQUE index on org_name
ALTER TABLE  `nucleus`.`organization` ADD UNIQUE  `UniqueIntouchOrgNameIndex` (  `org_name` )

#Adding till_id and till_password
#ALTER TABLE  `nucleus`.`organization` ADD `till_id` VARCHAR( 50 ) NOT NULL AFTER  `org_name`
#ALTER TABLE  `nucleus`.`organization` ADD `till_password` VARCHAR( 50 ) NOT NULL AFTER  `till_id`


# ---------------------------------------- CHANNELS ------------------------------------#
# Adding column `description` to channels table
ALTER TABLE  `nucleus`.`channels` ADD  `description` VARCHAR( 50 ) NOT NULL AFTER  `channel_name`

# Adding UNIQUE index on org_name
ALTER TABLE  `nucleus`.`channels` ADD UNIQUE  `UniqueChannelNameIndex` (  `channel_name` )


# ---------------------------------------- FIELD_VALIDATORS ------------------------------------#
# Adding UNIQUE index on validator_name
ALTER TABLE  `nucleus`.`field_validators` ADD UNIQUE  `UniqueValidatorNameIndex` (  `validator_name` )
# Altering datatype of `namespace` field from INT(5) to varchar(5)
ALTER TABLE  `field_validators` CHANGE  `namespace`  `namespace` VARCHAR( 100 ) NOT NULL DEFAULT 'string'


# ---------------------------------------- DATA_FIELDS_TYPE ------------------------------------#
# Adding UNIQUE index on type
ALTER TABLE `nucleus`.`data_fields_type` ADD UNIQUE `UniqueTypeIndex` (`type`)


# ---------------------------------------- DATA_FIELDS ------------------------------------#
# Adding UNIQUE index on data_field_name
ALTER TABLE  `nucleus`.`data_fields` ADD UNIQUE  `UniqueDataFieldNameIndex` (  `data_field_name` )

# Adding `is_array` field
ALTER TABLE  `data_fields` ADD  `is_array` INT NOT NULL DEFAULT  '0' COMMENT  'This will be a boolean indicating 
if the data-field is an array of some datatype' AFTER  `data_field_name`

# Renaming `data_fields_type_id` to `base_type_id` and giving it a default value of '-1'
ALTER TABLE  `data_fields` CHANGE  `data_fields_type_id`  `base_type_id` INT( 5 ) NOT NULL COMMENT  'This will be 
an ID of the `data-field-type` table since the data-field has a basic datatype'  DEFAULT  '-1'

# Adding `complex_type_id` field and giving it a default value of '-1'
ALTER TABLE  `data_fields` ADD  `complex_type_id` INT( 5 ) NOT NULL DEFAULT  '-1' COMMENT  'This will be 
an ID of this same table since the data-field has a data-type of an existing complex data-field' AFTER  `base_type_id`

# Adding `parent_type_id` field and giving it a default value of '-1'
ALTER TABLE  `data_fields` ADD  `parent_type_id` INT( 5 ) NOT NULL DEFAULT  '-1' COMMENT  'This will be 
an ID of this same table since the data-field is an assoc''s key' AFTER  `complex_type_id`


# ---------------------------------------- DATA_FIELD_VALIDATOR ------------------------------------#
# Creating `id` column and adding PRIMARY index on it
ALTER TABLE `nucleus`.`data_field_validator`  ADD `id` INT NOT NULL AUTO_INCREMENT FIRST,  ADD PRIMARY KEY (`id`) 


# ---------------------------------------- ORG_DATA_FIELDS ------------------------------------#
# Adding UNIQUE index on org_data_field_name
ALTER TABLE  `nucleus`.`org_data_fields` ADD UNIQUE  `UniqueODFNameIndex` (  `org_data_field_name` )


# ---------------------------------------- ORG_DATA_FIELD_VALIDATOR ------------------------------------#
# Creating `id` column and adding PRIMARY index on it
ALTER TABLE `nucleus`.`org_data_field_validator`  ADD `id` INT NOT NULL AUTO_INCREMENT FIRST,  ADD PRIMARY KEY (`id`) 

# ---------------------------------------- FIELD_VALIDATOR ------------------------------------#
# Modifing namespace column to varchar(100)

alter table field_validators change column namespace namespace varchar(100);
