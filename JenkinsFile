pipeline {
    agent any
    tools { nodejs "node"}
    
stages {
        stage('start message'){
            steps {
                echo '测试 TEXT 消息...'
            }
            post {
                success {
                    dingtalk (
                        robot: 'SECc447a58583c5b67e7df21836d0b788c852bb4b8c311d746709a0785789ccf7d3',
                        type: 'LINK',
                        atAll:true,
                        messageUrl: 'https://github.com/Jankos-Lee/notes4u.cn',
                        picUrl: 'http://notes4u.cn/cool/',
                        text: [
                            '---- start pull branch main ----',
                            '---- 开始构建前端项目  -----'
                        ],
                        // at: [],
                    )
                }
            }
        }
    stage('Pull code') {
        steps {
            // Get branch lastest code from a GitHub repository
            echo 'custom notes: --------- start pull code  ---------------'
            git branch: 'main',
                credentialsId: '49ce9a38-48b5-4580-b93c-f7928677760f',
                url: 'git@github.com:Jankos-Lee/notes4u.cn.git'
        }
    }
    stage('Build') {
        steps {
            // Get branch lastest code from a GitHub repository
            echo 'custom notes: -------- start build -------- '
            
            echo 'custom notes: -------- node version -------- '
            sh 'node --version'
            // 安装依赖
            echo 'custom notes: -------- install node module packages -------- '
            sh 'npm install --registry=https://registry.npm.taobao.org'
            // 打包构建
            echo 'custom notes: -------- start build -------- '
            sh 'npm run build'
            
            // sh 'mkdir md-notes'
            // 重命名打包名
            // sh 'mv md-notes ./md-notes'
            // 压缩，方便更快传输到目标应用服务器
            sh 'tar -czvf md-notes.tar.gz md-notes'
            // 控制台打印
            echo "custom notes: -------- build success --------"

        }

    }
    stage('Deploy') {
        steps {
            echo 'deploy start...'
            // sh 'ls'
            // sh 'cd ..'
            //  sshPublisher(publishers: [sshPublisherDesc(configName: 'notes ssh publish', transfers: [sshTransfer(cleanRemote: false, excludes: '', execCommand: 'cd /www/wwwroot/notes4u.cn;echo Jenkins >> test1.txt', execTimeout: 120000, flatten: false, makeEmptyDirs: false, noDefaultExcludes: false, patternSeparator: '[, ]+', remoteDirectory: '/www/wwwroot/notes4u.cn/', remoteDirectorySDF: false, removePrefix: '', sourceFiles: '*.txt')], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: false)])
            sshPublisher(publishers: [sshPublisherDesc(configName: 'notes ssh publish', transfers: [sshTransfer(cleanRemote: false, excludes: '', execCommand: 'cd /www/wwwroot/notes4u.cn; tar -xzf md-notes.tar.gz', execTimeout: 120000, flatten: false, makeEmptyDirs: false, noDefaultExcludes: false, patternSeparator: '[, ]+', remoteDirectory: '/www/wwwroot/notes4u.cn/', remoteDirectorySDF: false, removePrefix: '', sourceFiles: 'md-notes.tar.gz')], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: false)])
            echo 'deploy success'
        }
    }
    stage('finished message'){
            steps {
                echo 'fineshed...'
            }
            post {
                success {
                    dingtalk (
                        robot: 'SECc447a58583c5b67e7df21836d0b788c852bb4b8c311d746709a0785789ccf7d3',
                        type: 'TEXT',
                        atAll:true,
                        text: [
                            '---- finished frontend deploy ----',
                            '---- 构建完成  -----'
                        ],
                        // at: [],
                    )
                }
            }
        }
    }
}