# camunda-php
Alternative PHP SDK for Camunda REST API. Not yet functional.

## Goals
- PSR2 compliant
- Improve type hinting
- Guzzle
- Split the SDK into smaller components (roughly grouped in the same way the Camunda manual is)
- More fine-grained exception handling

## Approach
Take Camunda's Swagger file and perform codegen.
- Their swagger document has many errors, so the codegen tool fixes those first
- Allow modification of the swagger document before doing codegen (their swagger document isn't entirely accurate)
- Allow custom mapping of swagger schemas to specific namespace/classes