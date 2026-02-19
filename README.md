# NuMindsTech

This repository contains the source for the Numinds Tech website and
administration back‑end. The codebase is structured so that the public
front‑end lives under `public/` and configuration, controllers, and helpers
live under the `app/` directory.

## Entry point

A convenience bootstrap file `index.php` now lives in the project root. It
serves as a generic entry point for both web and CLI use:

- **Web**: requests hitting the project directory will be redirected to
  `public/index.php`, allowing hosts that make the project root their
document root to work without further changes.
- **CLI**: run commands from the root without the long paths:
  ```sh
  php index.php deploy   # run deployment checks
  php index.php migrate  # execute database migrations
  ```

Feel free to extend the CLI switch statement with additional tasks like
seeding, tests, etc.
