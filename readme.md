# Access console command

program check access by username & function name 

## Requirements

- docker & docker-compose 
or
- php 8.2 & Mysql8+

## Install

```bash
# Clone repo
git clone https://github.com/rakkot-vm/access.git
# start docker
docker-compose up -d
# run command
php console.php has-access "User 4" "Function 4"
