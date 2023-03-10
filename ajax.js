$(document).ready(function()
{
    $("#insert_book").submit(function(e)
    {
        e.preventDefault();
        $.ajax(
        {
            method: "post",
            url: "insertion.php",
            data: $(this).serialize(),
            datatype: "text",
            success: function(Result)
            {
                $("#response").html(Result);
            }
        });
    });
    $("#search").submit(function(e)
    {
        e.preventDefault();
        $.ajax(
        {
            method: "post",
            url: "search.php",
            data: $(this).serialize(),
            datatype: "text",
            success: function(Result)
            {
                $("#booktable").html(Result);
            }
        });
    });
    $("#issueform").submit(function(e)
    {
        e.preventDefault();
        $.ajax(
        {
            method: "post",
            url: "issue.php",
            data: $(this).serialize(),
            datatype: "text",
            success: function(Response)
            {
                $("#response").html(Response);
            }
        });
    });
    $("#returnform").submit(function(e)
    {
        e.preventDefault();
        $.ajax(
        {
            method: "post",
            url: "return.php",
            data: $(this).serialize(),
            datatype: "text",
            success: function(Response)
            {
                $("#responsereturn").html(Response);
            }
        });
    });
    $("#memberform").submit(function(e)
    {
        e.preventDefault();
        $.ajax(
        {
            method: "post",
            url: "member.php",
            data: $(this).serialize(),
            datatype: "text",
            success: function(Response)
            {
                $("#response").html(Response);
            }
        });
    });
});