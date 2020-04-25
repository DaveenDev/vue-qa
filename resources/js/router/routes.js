import QuestionsIndex from '../pages/QuestionsIndex.vue';
import QuestionPage from '../pages/QuestionPage.vue';
import NewQuestion from '../pages/NewQuestion.vue';
import EditQuestion from '../pages/EditQuestion.vue';
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
        path: '/questions/create',
        component: NewQuestion,
        name: 'questions.create'
    },
    {
        path: '/questions/:id/edit',
        component: EditQuestion,
        name: 'questions.edit'
    },
    {
        path: '/questions/:id/delete',
        component: '',
        name: 'questions.delete'
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