<?php

namespace LiveHelperChatExtension\cbscheduler\providers {

    class CBSchedulerRestAPI {

        public static function swaggerDefinition($params) {

            $params['append_paths'] .= ',"/restapi/cbschedulerlist": {
      "get": {
        "tags": [
          "cbscheduler"
        ],
        "summary": "Returns list of scheduler callbacks",
        "description": "",
        "produces": [
          "application/json"
        ],
        "parameters": [
        {
            "name": "departament_ids",
            "in": "query",
            "description": "Department ID\'s",
            "required": false,
            "type": "array",
            "items":{
              "type":"integer"
            }
          },
          {
            "name": "user_ids",
            "in": "query",
            "description": "User IDs",
            "required": false,
            "type": "array",
            "items":{
              "type":"integer"
            }
          },
          {
            "name": "status_ids",
            "in": "query",
            "description": "status_ids.\nconst STATUS_SCHEDULED = 0;\nconst STATUS_COMPLETED = 1;\nconst STATUS_CANCELED = 2;\nconst NOT_ANSWERED = 3;",
            "required": false,
            "type": "array",
            "items":{
              "type":"integer"
            }
          },
          {
            "name": "limit",
            "in": "query",
            "description": "Limit",
            "required": false,
            "type": "string",
            "format": "int32"
          },
            {
            "name": "offset",
            "in": "query",
            "description": "Offset",
            "required": false,
            "type": "string",
            "format": "int32"
          },
          {
            "name": "id_gt",
            "in": "query",
            "description": "ID greater than",
            "required": false,
            "type": "string",
            "format": "int32"
          },            
        ],
        "responses": {
          "200": {
            "description": "List of scheduler callbacks",
            "schema": {
            }
          },
          "400": {
            "description": "Error",
            "schema": {
            }
          }
        },
        "security": [
          {
            "login": []
          }
        ]
      }
    },
    "/restapi/cbschedulerfetch/{id}": {
      "get": {
        "tags": [
          "cbscheduler"
        ],
        "summary": "Fetch a scheduled call",
        "description": "",
        "produces": [
          "application/json"
        ],
        "parameters": [
        {
            "name": "id",
            "in": "path",
            "description": "Scheduled call ID",
            "required": true,
            "type": "integer",
          }            
        ],
        "responses": {
          "200": {
            "description": "Fetched scheduled call id",
            "schema": {
            }
          },
          "400": {
            "description": "Error",
            "schema": {
            }
          }
        },
        "security": [
          {
            "login": []
          }
        ]
      }
    },"/restapi/cbschedulercount": {
      "get": {
        "tags": [
          "cbscheduler"
        ],
        "summary": "Returns count of scheduler callbacks",
        "description": "",
        "produces": [
          "application/json"
        ],
        "parameters": [   
            {
            "name": "departament_ids",
            "in": "query",
            "description": "Department ID\'s",
            "required": false,
            "type": "array",
            "items":{
              "type":"integer"
            }
          },
          {
            "name": "user_ids",
            "in": "query",
            "description": "User IDs",
            "required": false,
            "type": "array",
            "items":{
              "type":"integer"
            }
          },
          {
            "name": "status_ids",
            "in": "query",
            "description": "status_ids.\nconst STATUS_SCHEDULED = 0;\nconst STATUS_COMPLETED = 1;\nconst STATUS_CANCELED = 2;\nconst NOT_ANSWERED = 3;",
            "required": false,
            "type": "array",
            "items":{
              "type":"integer"
            }
          },
          {
            "name": "id_gt",
            "in": "query",
            "description": "ID greater than",
            "required": false,
            "type": "string",
            "format": "int32"
          },         
        ],
        "responses": {
          "200": {
            "description": "Count of scheduler callbacks",
            "schema": {
            }
          },
          "400": {
            "description": "Error",
            "schema": {
            }
          }
        },
        "security": [
          {
            "login": []
          }
        ]
      }
    }';

            $params['append_definitions'] .= '"CBScheduler": {
      "type": "object",
      "properties": {
        "schedule_id": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Schedule ID. What schedule was used."
        },
        "slot_id": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Slot ID. What slot was used from the scheduler"
        },
        "dep_id": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Department ID"
        },
        "status_accept": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Auto acceptance status of the callback by operator. \nconst PENDING_ACCEPT = 0;\nconst CALL_ACCEPTED = 1;"
        },
        "tslasign": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Time stamp of the last auto assignment."
        },
        "tz": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Time zone of scheduled callback"
        },
        "cb_time_start": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Scheduled callback start time in unixtimestamp format"
        },
        "cb_time_end": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Scheduled callback end time in unixtimestamp format"
        },
        "status": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Callback status. One of - \nconst STATUS_SCHEDULED = 0;\nconst STATUS_COMPLETED = 1;\nconst STATUS_CANCELED = 2;\nconst NOT_ANSWERED = 3; "
        },
        "code": {
          "type": "string",
          "default": "",
          "required": true,
          "description": "Unique callback code used for call canceling."
        }, 
        "name": {
          "type": "string",
          "default": "",
          "required": true,
          "description": "Visitor name"
        }, 
        "email": {
          "type": "string",
          "default": "",
          "required": true,
          "description": "Visitor e-mail"
        }, 
        "phone": {
          "type": "string",
          "default": "",
          "required": true,
          "description": "Visitor phone"
        }, 
        "description": {
          "type": "string",
          "default": "",
          "required": true,
          "description": "Visitor description of the issue."
        },
        "outcome": {
          "type": "string",
          "default": "",
          "required": true,
          "description": "Operator notices regarding callback outcome."
        },
        "region": {
          "type": "string",
          "default": "",
          "required": true,
          "description": "Customer region"
        },
        "ctime": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Unix timestamp of the scheduled callback"
        },
        "subject_id": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Related subject ID from callback subjects table"
        },
        "chat_id": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Related chat ID"
        },
        "user_id": {
          "type": "integer",
          "default": "0",
          "required": true,
          "description": "Operator ID"
        },
        "parent_id": {
          "type": "integer",
          "default": "",
          "required": true,
          "description": "If call was scheduled based on previous call. This is parent scheduled callback id."
        },
        "daytime": {
          "type": "integer",
          "required": false,
          "description": "Integer represents Ymd format.",
          "example": "20210324"
        },
        "verified": {
          "type": "integer",
          "required": false,
          "description": "0/1 - is a caller verified or not",
          "example": null
        },
        "log_actions": {
          "type": "string",
          "required": false,
          "description": "History notices related to specific scheduled call."
        }
      },
      "example" : {
        "msg" : "Message to visitor",
        "phone_number" : "+37065272xxx",
        "create_chat" : true,
        "twilio_id" : 1
      }
    },';
        }
    }
}