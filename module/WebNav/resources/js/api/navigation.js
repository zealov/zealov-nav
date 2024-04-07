import request from "@/utils/request";

export function index(data) {
    return request({
        url: "/WebNav/navigation",
        method: "get",
        params: data,
    });
}

export function store(data) {
    return request({
        url: "/WebNav/navigation",
        method: "post",
        data,
    });
}

export function updateSort(data) {
    return request({
        url: "/WebNav/navigation/updateSort",
        method: "post",
        data,
    });
}

export function show(id) {
    return request({
        url: "/WebNav/navigation/" + id,
        method: "get",
    });
}

export function update(id, data) {
    return request({
        url: "/WebNav/navigation/" + id,
        method: "put",
        data,
    });
}

export function destroy(id) {
    return request({
        url: "/WebNav/navigation/" + id,
        method: "delete",
    });
}
