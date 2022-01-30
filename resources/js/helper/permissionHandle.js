import axios from 'axios';

export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        // window.document.title = to.meta.pageTitle !== undefined ? to.meta.pageTitle : '';
        // let permission_name = to.meta.permissionName ? to.meta.permissionName.toLowerCase() : "";
        // let hasPermission = Array.isArray(Permissions) ? Permissions.includes(permission_name) : false;
        // if (hasPermission) {
        //     next();
        // } else {
        //     var dashboard_redirect = {
        //         '/admin/dashboard': '/admin/home'
        //     }
        //     if (dashboard_redirect[to.path]) {
        //         router.push({
        //             path: dashboard_redirect[to.path]
        //         })
        //     } else {
        //         router.push({
        //             'path': '/'
        //         })
        //     }
        //
        // }
        next();
    });
    axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

    axios.interceptors.response.use(function (response) {
        return response;
    }, function (error) {
        if (parseInt(error.response.status) === 401) {
            // store.commit('logout');
        }
        return Promise.reject(error);
    });

}
