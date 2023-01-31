startTime=20230131-16:58:40
startTime_s=1675155520
currentTime=$1
currentTime_s=$2
if [ ! -n "$recordStartTime" ]
then
IS NULL
else
sumTime=$[ $currentTime_s - $startTime_s ]
"$startTime ---> $currentTime" "--------本次构建总用时--------:$sumTime seconds"
fi
