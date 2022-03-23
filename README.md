# pds/skeleton

This publication describes a standard filesystem skeleton suitable for all PHP
packages.

## Summary

A package MUST use these names for these root-level directories:

| If a package has a root-level directory for ... | ... then it MUST be named: |
| ----------------------------------------------- | -------------------------- |
| documentation files                             | `docs/`                    |
| PHP source code                                 | `src/`                     |
| test code                                       | `tests/`                   |

### docs/

If the package provides a root-level directory for documentation files, it MUST
be named `docs/`.

This publication does not otherwise define the structure and contents of the
directory.

### src/

If the package provides a root-level directory for PHP source code files, it
MUST be named `src/`.

This publication does not otherwise define the structure and contents of the
directory.

### tests/

If the package provides a root-level directory for test files, it MUST be named
`tests/`.

This publication does not otherwise define the structure and contents of the
directory.