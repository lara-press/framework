# -*- mode: ruby -*-
# vi: set ft=ruby :

# Config Github Settings
github_username = "fideloper"
github_repo     = "Vaprobash"
github_branch   = "1.4.2"
github_url      = "https://raw.githubusercontent.com/#{github_username}/#{github_repo}/#{github_branch}"

# Because this:https://developer.github.com/changes/2014-12-08-removing-authorizations-token/
# https://github.com/settings/tokens
github_pat          = "90a2111d58f07e3ccd023f5f9f2f803f835b9d3d"

# Server Configuration

hostname        = "mccalljewelry.dev"

# Set a local private network IP address.
# See http://en.wikipedia.org/wiki/Private_network for explanation
# You can use the following IP ranges:
#   10.0.0.1    - 10.255.255.254
#   172.16.0.1  - 172.31.255.254
#   192.168.0.1 - 192.168.255.254
server_ip       = "192.168.22.10"

server_cpus           = "1"   # Cores
server_memory         = "2048" # MB
server_swap           = "4096" # Options: false | int (MB) - Guideline: Between one or two times the server_memory

server_timezone  = "US/Mountain"

# Database Configuration
mysql_root_password   = "root"   # We'll assume user "root"
mysql_enable_remote   = "true"  # remote access enabled when true

# Languages and Packages
php_timezone          = "America/Boise"    # http://php.net/manual/en/timezones.php
php_version           = "5.6"    # Options: 5.5 | 5.6

# To install HHVM instead of PHP, set this to "true"
hhvm                  = "false"

# PHP Options
composer_packages     = [        # List any global Composer packages that you want to install
  "phpunit/phpunit:4.0.*",
  "codeception/codeception=*",
  "phpspec/phpspec:2.0.*@dev",
  "squizlabs/php_codesniffer:1.5.*",
]

# Default web server document root
# Symfony's public directory is assumed "web"
# Laravel's public directory is assumed "public"
public_folder       = "/development/mccalljewelry/public"

nodejs_version        = "latest"   # By default "latest" will equal the latest stable version
nodejs_packages       = [          # List any global NodeJS packages that you want to install
  "gulp",
  "bower",
]

Vagrant.configure("2") do |config|

  # Set server to Ubuntu 14.04
  config.vm.box = "ubuntu/trusty64"

  if Vagrant.has_plugin?("vagrant-hostmanager")
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.ignore_private_ip = false
    config.hostmanager.include_offline = false
  end

  config.vm.synced_folder ".", "/vagrant", disabled: true

  config.vm.define "dev" do |dev|

    config.vm.network :private_network, :ip => "0.0.0.0", :auto_network => true

    config.vm.hostname = hostname
    config.vm.synced_folder "./", "/development/mccalljewelry",
      id: "core",
      :nfs => true,
      :mount_options => ['nolock,vers=3,udp,noatime,actimeo=2,fsc']

    config.vm.provider :virtualbox do |vb|

      vb.name = hostname

      # Set server cpus
      vb.customize ["modifyvm", :id, "--cpus", server_cpus]

      # Set server memory
      vb.customize ["modifyvm", :id, "--memory", server_memory]

      # Set the timesync threshold to 10 seconds, instead of the default 20 minutes.
      # If the clock gets more than 15 minutes out of sync (due to your laptop going
      # to sleep for instance, then some 3rd party services will reject requests.
      vb.customize ["guestproperty", "set", :id, "/VirtualBox/GuestAdd/VBoxService/--timesync-set-threshold", 10000]

      # Prevent VMs running on Ubuntu to lose internet connection
      vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
      vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]

    end

    # Provision Base Packages
    config.vm.provision "shell", path: "#{github_url}/scripts/base.sh", args: [github_url, server_swap, server_timezone]

    # optimize base box
    config.vm.provision "shell", path: "#{github_url}/scripts/base_box_optimizations.sh", privileged: true

    # Provision Vim
    # config.vm.provision "shell", path: "#{github_url}/scripts/vim.sh", args: github_url

    # Provision PHP
    config.vm.provision "shell", path: "#{github_url}/scripts/php.sh", args: [php_timezone, hhvm, php_version]

    # Provision Apache Base
    config.vm.provision "shell", path: "#{github_url}/scripts/apache.sh", args: [server_ip, public_folder, hostname, github_url]

    # Install Nodejs
    config.vm.provision "shell", path: "#{github_url}/scripts/nodejs.sh", privileged: false, args: nodejs_packages.unshift(nodejs_version, github_url)

    # Provision Composer
    # You may pass a github auth token as the first argument
    config.vm.provision "shell", path: "#{github_url}/scripts/composer.sh", privileged: false, args: [github_pat, composer_packages.join(" ")]

    # Install Mailcatcher
    config.vm.provision "shell", path: "#{github_url}/scripts/mailcatcher.sh"

  end

  # Enable agent forwarding over SSH connections
  config.ssh.forward_agent = true

  # Replicate local .gitconfig file if it exists
  if File.file?(File.expand_path("~/.gitconfig"))
    config.vm.provision "file", source: "~/.gitconfig", destination: ".gitconfig"
  end

end
