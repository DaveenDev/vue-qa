export default{
    modify(user,model){
        //console.log(model);
        //console.log('userID=' + user.id + '    question user ID=' + model.user.user_id)
        return user.id===model.user.user_id;
    },
    accept(user,answer){
        //console.log("userID=" + user.id + "   answer userID=" + answer.question.user_id );
        if (user.id===answer.question.user.user_id){
            return true;
        }else if(user.id===answer.user.user_id){
            //console.log("userID=" + user.id + "   answer userID=" + answer.user.user_id );
            return false;
        }
        
    },
    deleteQuestion(user,question){
        return user.id===question.user.user_id && question.answers_count<1;
    }
}