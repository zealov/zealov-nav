import request from "@/utils/request";
export function index(data) {
    return request({
        url: "/WebNav/config",
        method: "get",
        params: data,
    });
}
export function group(data) {
    return request({
        url: "/WebNav/config/group",
        method: "get",
        params: data,
    });
}
export function store(data) {
    return request({
        url: "/WebNav/config",
        method: "post",
        data,
    });
}
export function update(id, data) {
    return request({
        url: "/WebNav/config/" + id,
        method: "put",
        data,
    });
}


export function show(id) {
    return request({
        url: "/WebNav/config/" + id,
        method: "get",
    });
}
