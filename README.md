# Pre-requisites  
- PHP **>= 8.0** (Check version: `php -v`)  
- Composer installed (Check version: `composer -V`)  

#
# Setup & Run  
```bash
> composer install
> composer run serve
```

#
# Troubleshooting
- If you encounter issues, try the following:
    ```bash
    > composer dump-autoload
    > composer run serve
    ```
- Reinstall dependencies
    ```bash
    # Windows (PowerShell)
    > Remove-Item -Recurse -Force vendor

    # macOS/Linux
    > rm -rf vendor

    > composer install
    > composer run serve
    ```

