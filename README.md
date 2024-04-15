# Synology GoDaddy DDNS Script 📜

This script enables you to use [GoDaddy](https://www.godaddy.com/) as a Dynamic DNS (DDNS) service for [Synology](https://www.synology.com/) NAS devices. It leverages the GoDaddy v1 API to update DNS records dynamically.

## How to Use

### Accessing Synology via SSH

1. **Login to DSM:**
   - Navigate to `Control Panel` > `Terminal & SNMP`.
   - Enable the SSH service.
   
2. **SSH into Synology:**
   - Use an SSH client to connect to your Synology device.
   - Login using your Synology admin credentials.

### Setting Up the Script

1. **Download the Script:**
   - Download `godaddy.php` to your Synology device using the command below:
     ```
     wget https://raw.githubusercontent.com/cchengleo/SynologyGoDaddyDDNS/main/godaddy.php -O /usr/syno/bin/ddns/godaddy.php
     ```
   - Note: You can place the script in any directory and rename it as you wish, but ensure to adjust the path in subsequent commands accordingly.

2. **Make the Script Executable:**
   - Grant execute permissions to the script:
     ```
     chmod +x /usr/syno/bin/ddns/godaddy.php
     ```

3. **Register the Script with Synology:**
   - Add `godaddy.php` to the Synology DDNS service:
     ```
     cat >> /etc.defaults/ddns_provider.conf << EOF
     [GoDaddy]
             modulepath=/usr/syno/bin/ddns/godaddy.php
             queryurl=https://www.godaddy.com
             website=https://www.godaddy.com
     EOF
     ```
   - The `queryurl` parameter is required but not used by the script.

### Obtaining GoDaddy API Keys

- Visit [GoDaddy API Keys](https://developer.godaddy.com/keys/) and click on "Create New API Key."
- Name your key (e.g., "Dynamic DNS") and select the appropriate environment.
- Note your API key and secret. The key remains visible in your account, but the secret is shown only once and cannot be retrieved if lost.

### Configuring DDNS in DSM

- Log into DSM and navigate to `Control Panel` > `External Access` > `DDNS` > `Add`.
- Configure the new DDNS entry:
  - **Service Provider:** `GoDaddy`
  - **Hostname:** `<DNS Record to be updated>` (e.g., `myhostname`)
  - **Username/Email:** `<Your domain name>` (e.g., `mydomain.com`)
  - **Password Key:** `<API Key>`:`<Secret>`
