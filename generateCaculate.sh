#get current time
#current_date=$(date +%c)

startTime=`date +%Y%m%d-%H:%M:%S`
startTime_s=`date +%s`

# write the temp file to record the start build timestamp and calculate the execution time for this build
tempfile=`mktemp calulate.sh`
exec 3>$tempfile

echo "This script writes to temp file $tempfile"

echo "startTime="$startTime >&3
echo "startTime_s="$startTime_s >&3
echo 'currentTime=$1' >&3
echo 'currentTime_s=$2' >&3
echo if [ ! -n '"$recordStartTime"' ] >&3
echo  then  >&3
echo "IS NULL" >&3
echo  else  >&3
echo sumTime='$[ $currentTime_s - $startTime_s ]' >&3
echo '"$startTime ---> $currentTime" "--------本次构建总用时--------:$sumTime seconds"' >&3
echo fi >&3

exec 3>&-
