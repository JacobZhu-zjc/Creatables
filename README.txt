Since MySQL does not support assertions, we used a CHECK in order to ensure that all Feedback contains at least one non-null field.
This enforces the "full cover" constraint on the ISA relationship.
See database_setup.sql:61
