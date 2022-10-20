/**
 * 
 * @param {Number} delaySecond 延迟毫秒
 * @param {func} queryFn 查询函数
 * @returns 
 */
const excuetePeriodTimeout = (delaySecond, queryFn) => {
    return new Promise((resolve) => {
        setTimeout(() => {
            const queryFnResl = queryFn && queryFn();
            if (queryFnResl) {
                resolve(true)
            } else {
                resolve(false)
            }
        }, delaySecond)
    })
}

/**
 * 
 * @param {func} queryFn 
 * @param {func} callback 
 * @returns 
 */
const simplePoller = async (queryFn, callback) => {
    let cnt = 1
    let delayTime = 1500
    while (true) {
        if (cnt === 1) {
            const fnResl = await excuetePeriodTimeout(1000, queryFn)
            if(fnResl) {
                callback()
                return
            }
        }
        cnt++
        const fnResl = await excuetePeriodTimeout(delayTime * cnt, queryFn)
        if(fnResl) {
            callback()
            return
        }
        delayTime = delayTime * 1.5
    }
}