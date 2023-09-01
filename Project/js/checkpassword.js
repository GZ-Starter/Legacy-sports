function CheckPassword(inputtext)
{
    var passw=/^(?=.*\d)(?=.*[a-z]).{8,15}$/;
    // (?=.*[A-Z])
    if(inputtext.value.match(passw))
    {
        // alert('Correct,try something else...')
        return true;
    }
    else{
        alert('Password must contain aleast on character and digit...')
        return false;
    }
}