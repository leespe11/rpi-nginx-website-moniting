#!/bin/sh
normalDate=`date +"%D-%T"`
start=`date +%s`
alive_hosts="/tmp/alive_hosts.txt"
hosts="/tmp/hosts.txt"
all_hosts="/tmp/all_hosts.txt"
host_info="/tmp/host_info.txt"

mailer(){
      if [ "$1" == "1" ];then
         updown="DOWN"
      else
         updown="UP"
      fi

      echo `mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e "SELECT name, '|', ipaddress, '|', OS FROM servers where ipaddress='$2';"` > $host_info
      NAME=`cat $host_info | cut -d '|' -f1`
      IP=`cat $host_info | cut -d '|' -f2`
      OS=`cat $host_info | cut -d '|' -f3`
      if ! echo "$NAME" | grep -i "Unknown" ;then
         curl -s -d "token=d2CMKTRQ3RMWED6DDAJ2SzU5TrTGEGG2UuWMsqQjQXRZRNfd7r6w67PX85tFvcc4&server_name=$NAME&ip_address=$IP&OS=$OS&status=$updown" http://nginx_net/mail.php > /dev/null
      fi
      rm $host_info
}

echo -e `mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e "SELECT ipaddress FROM servers;"` | \
tr ' ' '\n' | \
while read l
do
    echo "$l" >> $hosts
done

echo `mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e "SELECT value FROM subnets;"` | \
tr ' ' '\n' | \
while read l
do
    fping -a -g 192.168.$l.0/24 > /dev/null 2>&1 >> $all_hosts
done

while read l
do
   grep -q "$l" $hosts 2>&1 /dev/null
   if [ "$?" != 0 ];then
      mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e  "INSERT INTO servers (name, ipaddress, dhcp, type, OS, status) VALUES ('Unknown', '$l', 0, 'n/a', 'n/a', 1);";
   fi
done < $all_hosts

fping -a -f $hosts > /dev/null 2>&1 >> $alive_hosts

#echo -e `mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e "SELECT ipaddress FROM servers;"` > $hosts

while read l
do
  status=`mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e "SELECT status FROM servers where ipaddress='$l';"`
  grep -q "$l" $alive_hosts 2>&1 /dev/null
  result="$?"
  if [ "$result" != 0 ];then
     #server down
     mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e "UPDATE servers set status=0 where ipaddress='$l';"
  else
     #server up
     mysql -sN -h mysql_net -u jobber --password="jobber!@1001" -D updownio -e "UPDATE servers set status=1 where ipaddress='$l';"
  fi
  # COMMENT OUT MAILER
  #if [ "$result" == "$status" ] && ! grep -q "$l" $all_hosts 2>&1 /dev/null;then
     #mailer "$result" "$l"
  #fi
done < $hosts

rm $all_hosts $alive_hosts $hosts
end=`date +%s`
runtime=$((end-start))
echo "$normalDate UpDown Script Execution Time: $runtime seconds" >> /opt/updown.log
