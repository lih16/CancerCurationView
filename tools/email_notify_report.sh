#!/usr/bin/env bash
declare -A emailnotify
 i=0;
 sendString=""
 emailList="osman.siddiqui@sema4genomics.com,osmosis11@gmail.com,osman.siddiqui11@gmail.com"
 while read cancer gene variant; do

emailnotify[$i]=$gene" "$cancer" "$variant;

echo "aaa"${emailnotify[$i]};
let i=i+1;
mysql -h ec2-34-234-146-130.compute-1.amazonaws.com -u siddio01 -pfBNsPQ8YKF4G75vjA3zkzPAJ -D kb_CancerVariant_Curation -bse  "update kb_CancerVariant_Curation.CVC_viewer_editor_report set status=1 where cancer='$cancer' and gene='$gene' and varaint='$variant'"
done < <(echo "select cancer,gene,varaint from kb_CancerVariant_Curation.CVC_viewer_editor_report where   status=0 group by cancer,gene,varaint" | mysql -h ec2-34-234-146-130.compute-1.amazonaws.com -u siddio01 -pfBNsPQ8YKF4G75vjA3zkzPAJ -D kb_CancerVariant_Curation -N)
            #select view-editor only status=0 using group by to remove the duplication

for i in "${!emailnotify[@]}"
do
sendString=$sendString"\n"${emailnotify[$i]};

done

echo -e "To:$emailList\nFrom: CAV_Updates<cav-updates@sema4genomics.com\nSubject: New Editor Comments $sendString." | /usr/sbin/sendmail -t
