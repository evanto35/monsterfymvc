<?php

abstract class Query {

##################################################################
###################								 #################
###################	  		   SYSTEM			 #################
###################								 #################
##################################################################
	
const SYSTEM_GET_TABLES = "SELECT information_schema.tables.table_name
							 FROM information_schema.tables
							WHERE information_schema.tables.table_schema = :schema";

const SYSTEM_GET_CLIENT_TYPES = "SELECT client_type.*
								   FROM client_type
								  ORDER BY client_type.description";

const SYSTEM_GET_EVENT_TYPES = "SELECT event_type.*
								  FROM event_type
								 ORDER BY event_type.description";

const SYSTEM_GET_PRODUCTS = "SELECT product.*
							   FROM product
							  ORDER BY product.description";

const SYSTEM_GET_PROMPTERS = "SELECT prompter.*
								FROM prompter
							   ORDER BY prompter.description";

const SYSTEM_GET_SALES_CHANNELS = "SELECT sales_channel.*
									 FROM sales_channel
								    ORDER BY sales_channel.description";

const SYSTEM_GET_USERS = "SELECT user.*
							FROM user
						   ORDER BY user.name";

##################################################################
###################								 #################
###################	  		  	TABLE			 #################
###################								 #################
##################################################################

const TABLE_GET_FIELDS = "SELECT information_schema.columns.column_name
							FROM information_schema.columns
						   WHERE information_schema.table_schema = :schema;
							 AND information_schema.table_name   = :table";

##################################################################
###################								 #################
###################	  		   	USER			 #################
###################								 #################
##################################################################

const USER_GEY_BY_LOGIN = "SELECT user.id,
								  user.name,
								  user.email,
								  user.admin
							 FROM user
							WHERE user.email 	= :user
							  AND user.password = :passwd";


##################################################################
###################								 #################
###################	  		   	CALLS			 #################
###################								 #################
##################################################################

const CALL_GET_ALL_BY_USER = "SELECT vw_calls.*
								FROM vw_calls
							   WHERE vw_calls.userId = :userId";

const CALL_GET_ALL = "SELECT vw_calls.*
						FROM vw_calls";

const CALL_INSERT = "INSERT INTO calls (user_id,
										dt_tm_start,
										pax_name,
										booking,
										client_type_id,
										sales_channel_id,
										summary,
										event_type_id,
										product_id,
										prompter_id)
								VALUES (:userId,
										:dtTmStart,
										:paxName,
										:booking,
										:clientTypeId,
										:salesChannelId,
										:summary,
										:eventTypeId,
										:productId,
										:prompterId)";

const CALL_UPDATE = "UPDATE calls
						SET calls.dt_tm_end  = :dtTmEnd,
							calls.resolution = :resolution
					  WHERE calls.id = :id";
}