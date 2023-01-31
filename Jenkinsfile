import java.text.SimpleDateFormat
import hudson.model.*

// TBD: 增加构建时间通知、手动配置参数选择
pipeline {
    agent any
    tools { nodejs "node"}
    
    options {
        // 表示保留5次构建历史
        buildDiscarder(logRotator(numToKeepStr: '5'))
        // 打印日志带上对应时间
        timestamps()
        // 任务时间超过10分钟，终止构建
        timeout(time: 10, unit: 'MINUTES')
    }

    parameters {
        string(name: 'INFO', defaultValue: '-- 简述更新内容 --', description: '-- 简述更新内容 --')
        string(name: 'REQUEST_URL', defaultValue: '-- 简述更新内容 --', description: '-- 输入请求地址 --')
        string(name: 'ENT_CODE', defaultValue: '-- 简述更新内容 --', description: '-- 输入企业号 --')
        string(name: 'VUE_APP_TITLE', defaultValue: '-- 简述更新内容 --', description: '-- 输入应用名称 --')

        string(name: 'BUILD_TIME', defaultValue: '-- 开始构建时间 --', description: '-- 开始构建时间 --')
        string(name: 'FINISHED_TIME', defaultValue: '-- 结束构建时间 --', description: '-- 结束构建时间 --')
    }

    environment {
		def PROJECT_NAME = 'md-notes' 
		def COMPILE_PATH = ''
		def change = ''
		def BUILD_USER = 'jankos'
    }
    
stages {
        stage('start message'){
            steps {
                // script {
                    // def now = new Date();
                    // def currentDate = now.format("MM/dd/yyyy")
                // }
                // 测试 build.sh 脚本中的变量
                sh "sh build.sh ${REQUEST_URL} ${ENT_CODE} ${VUE_APP_TITLE}"
                sh "sh generateCaculate.sh"
                echo "${REQUEST_URL} ${ENT_CODE} ${VUE_APP_TITLE}"
                echo '--------------------------------  send start message to dingtalk --------------------------------'
                // echo "${INFO} ----- ${currentDate}"
                echo "${INFO} ----- "
            }
            post {
                success {
                    dingtalk (
                        robot: 'SECc447a58583c5b67e7df21836d0b788c852bb4b8c311d746709a0785789ccf7d3',
                        type: 'TEXT',
                        atAll:true,
                        messageUrl: 'https://github.com/Jankos-Lee/notes4u.cn',
                        picUrl: 'http://notes4u.cn/cool/',
                        text: [
                            "开始构建项目: ### [${env.JOB_NAME}](${env.JOB_URL}) ###"
                            // "开始构建时间: ### ${BUILDVERSION_DATE} ### ",
                        ],
                    )
                }
            }
        }
    stage('Pull code') {
        steps {
            // Get branch lastest code from a GitHub repository
            echo '--------------------------------  pull code  --------------------------------'
            git branch: 'main',
                credentialsId: '49ce9a38-48b5-4580-b93c-f7928677760f',
                url: 'git@github.com:Jankos-Lee/notes4u.cn.git'
        }
    }
    stage('Build') {
        steps {
            echo '-------------------------------- start build -------------------------------- '
            echo '-------------------------------- node version --------------------------------'
            sh 'node --version'
            // 安装依赖
            echo '-------------------------------- install node module packages -------------------------------- '
            sh 'npm install --registry=https://registry.npm.taobao.org'
            // 打包构建
            echo '-------------------------------- start build --------------------------------'
            sh 'npm run build'
            // sh 'mkdir md-notes'
            // 重命名打包名
            // sh 'mv md-notes ./md-notes'
            // 压缩，方便更快传输到目标应用服务器
            sh 'tar -czvf md-notes.tar.gz md-notes'
            // 控制台打印
            echo "-------------------------------- build success --------------------------------"
        }

    }
    stage('Deploy') {
        steps {
            echo '-------------------------------- deploy start --------------------------------'
            sshPublisher(publishers: [sshPublisherDesc(configName: 'notes ssh publish', transfers: [sshTransfer(cleanRemote: false, excludes: '', execCommand: 'cd /www/wwwroot/notes4u.cn; tar -xzf md-notes.tar.gz', execTimeout: 120000, flatten: false, makeEmptyDirs: false, noDefaultExcludes: false, patternSeparator: '[, ]+', remoteDirectory: '/www/wwwroot/notes4u.cn/', remoteDirectorySDF: false, removePrefix: '', sourceFiles: 'md-notes.tar.gz')], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: false)])
            echo '-------------------------------- deploy success --------------------------------'
        }
    }
    stage('finished message'){
            steps {
                echo 'fineshed...'
                sh "sh finished.sh"
                script {
                    change = getChanges()
                }
            }
            post {
                success {
                    dingtalk (
                        robot: 'SECc447a58583c5b67e7df21836d0b788c852bb4b8c311d746709a0785789ccf7d3',
                        type: 'ACTION_CARD',
                        atAll:true,
                        text: [
                            "应用 ### [${env.JOB_NAME}](${env.JOB_URL}) ### 发布  <font color=#00CD00 >成功</font>！",
                            "- 任务名 ：[${currentBuild.displayName}](${env.BUILD_URL})",
                            "- 耗时：${currentBuild.durationString}".split("and counting")[0],
                            "- 执行人： ${BUILD_USER}",
                            "- 更新内容： ${change}"
                        ],
                        // at: [],
                    )
                }
            }
        }
    }
}

@NonCPS
def getChanges()
{
    MAX_MSG_LEN = 50
    def changeString = ""
    def changeLogSets = currentBuild.changeSets
    for (int i = 0; i < changeLogSets.size(); i++) 
    {
        def entries = changeLogSets[i].items
        for (int j = 0; j < entries.length; j++)
        {
            def entry = entries[j]
            change_msg = entry.msg.take(MAX_MSG_LEN)
            changeString += " ${change_msg} \n"
        }
    }
    if (!changeString)
    {
        changeString = " No changes "
    }
    return changeString  
}