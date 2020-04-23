import QuestionsIndex from '../pages/QuestionsIndex.vue';
import QuestionPage from '../pages/QuestionPage.vue';
import MyPostPage from '../pages/MyPostPage.vue';
import NotFoundPage from '../pages/NotFoundPage.vue';

const routes=[
    {
        path: '/',
        component: QuestionsIndex,
        name: 'home' 
    },
    {
        path: '/questions',
        component: QuestionsIndex,
        name: 'questions'
    },
    {
        path: '/my-posts',
        component: MyPostPage,
        name: 'my-posts',
        meta: {
            requiresAuth: true //this is to restric routes only for logged in users
        }
    },
    {
        path: '/questions/:slug',
        component: QuestionPage,
        name: 'questions.show'
    },
    {
        path: '*', //to return 404 page not found 
        component: NotFoundPage,
    }
];

export default routes;