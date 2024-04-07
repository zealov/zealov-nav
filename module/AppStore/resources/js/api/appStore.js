import request from "@/utils/request";


export function custom(action,data) {
    return request({
        url: "/appStore/"+action,
        method: "post",
        data,
    });
}




