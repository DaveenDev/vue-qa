export default{
    modify(user,model){
        return user.id===model.user_id;
    },
    accept(user,answer){
        //console.log("userID=" + user.id + "   answer userID=" + answer.question.user_id );
        if (user.id===answer.question.user_id){
            return true;
        }else if(user.id===answer.user_id){
            console.log("userID=" + user.id + "   answer userID=" + answer.user_id );
            return false;
        }
        
    },
    deleteQuestion(user,question){
        return user.id===question.user_id && question.answers_count<1;
    }
}