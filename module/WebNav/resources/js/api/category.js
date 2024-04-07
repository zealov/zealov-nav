import request from "@/utils/request";

export function category(data) {
    return request({
        url: "/WebNav/category",
        method: "get",
        params: data,
    });
}

export function create(data) {
    return request({
        url: "/WebNav/category",
        method: "post",
        data,
    });
}

export function updateSort(data) {
    return request({
        url: "/WebNav/category/updateSort",
        method: "post",
        data,
    });
}

export function show(id) {
    return request({
        url: "/WebNav/category/" + id,
        method: "get",
    });
}

export function update(id, data) {
    return request({
        url: "/WebNav/category/" + id,
        method: "put",
        data,
    });
}

export function destroy(id) {
    return request({
        url: "/WebNav/category/" + id,
        method: "delete",
    });
}
