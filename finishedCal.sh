startTime=`date +%Y%m%d-%H:%M:%S`
startTime_s=`date +%s`
sh "calulate.sh ${startTime} ${startTime_s}"
sh "rm -rf caculate.sh"