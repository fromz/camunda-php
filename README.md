# camunda-php
Alternative PHP SDK for Camunda REST API. Not entirely functional. Lots of copied code from the existing SDK.

## Goals
- PSR2 compliant
- Improve type hinting
- Guzzle
- Split the SDK into smaller components (roughly grouped in the same way the Camunda manual is)
- More fine-grained exception handling

## Approach
- Copy existing Request/Response/Service code from SDK
- Refactor a component at a time, allowing all others to be non-functional
