import Vue from 'vue';
import VueRouter from 'vue-router';

import About from './components/About';
import auth from './middleware/auth';
import Login from "./components/Login";
import Rubric from "./components/Rubric/Rubric";
import Articles from "./components/Article/Articles";
import CreateArticle from "./components/Article/CreateArticle";
import UpdateArticle from "./components/Article/UpdateArticle";
import RedBook from "./components/Red-book/RedBook";
import RedBookCreate from "./components/Red-book/RedBookCreate";
import RedBookUpdate from "./components/Red-book/RedBookUpdate";
import Authors from "./components/Author/Authors";
import PageNotFound from "./components/PageNotFound";
import CreateAuthor from "./components/Author/CreateAuthor";
import UpdateAuthor from "./components/Author/UpdateAuthor";
import FavouriteArticles from "./components/Article/FavouriteArticles";
import Feedbacks from "./components/Feedback/Feedbacks";
import Mailing from "./components/Mailing/Mailing";
import SubmitMailing from "./components/Mailing/SubmitMailing";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/admin/about',
            name: 'about',
            component: About,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/rubrics',
            name: 'rubrics',
            component: Rubric,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/login',
            name: 'login',
            component: Login
        },
        {
            path: '/admin/articles',
            name: 'articles',
            component: Articles,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/articles-create',
            name: 'create-article',
            component: CreateArticle,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/articles/:id',
            name: 'update-article',
            component: UpdateArticle,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/articles-favourite',
            name: 'favourite-articles',
            component: FavouriteArticles,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/red-book',
            name: 'red-book',
            component: RedBook,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/red-book-create',
            name: 'red-book-create',
            component: RedBookCreate,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/red-book/:id',
            name: 'update-red-book',
            component: RedBookUpdate,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/authors',
            name: 'authors',
            component: Authors,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/authors/create',
            name: 'create-author',
            component: CreateAuthor,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/authors/:id',
            name: 'update-author',
            component: UpdateAuthor,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/feedbacks',
            name: 'feedbacks',
            component: Feedbacks,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/mailings',
            name: 'mailings',
            component: Mailing,
            meta: {
                middleware: [auth]
            }
        },
        {
            path: '/admin/mailings/send-mailing',
            name: 'send-mailing',
            component: SubmitMailing,
            meta: {
                middleware: [auth],
            }

        },
        {path: "*", component: PageNotFound}

    ]
});

// Creates a `nextMiddleware()` function which not only
// runs the default `next()` callback but also triggers
// the subsequent Middleware function.
function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    // If no subsequent Middleware exists,
    // the default `next()` callback is returned.
    if (!subsequentMiddleware) return context.next;

    return (...parameters) => {
        // Run the default Vue Router `next()` callback first.
        context.next(...parameters);
        // Then run the subsequent Middleware with a new
        // `nextMiddleware()` callback.
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({...context, next: nextMiddleware});
    };
}

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware)
            ? to.meta.middleware
            : [to.meta.middleware];

        const context = {
            from,
            next,
            router,
            to,
        };
        const nextMiddleware = nextFactory(context, middleware, 1);

        return middleware[0]({...context, next: nextMiddleware});
    }

    return next();
});

export default router;
