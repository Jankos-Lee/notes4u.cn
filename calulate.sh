startTime=20230131-16:27:51
startTime_s=1675153671
currentTime=$1
currentTime_s=$2
if [ ! -n "$recordStartTime" ]
then
IS NULL
else
sumTime=$[ $currentTime_s - $startTime_s ]
"$startTime ---> $currentTime" "Total:$sumTime seconds"
fi
