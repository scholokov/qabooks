<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>QA Books</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
    <nav name="menu-main" id="menu-main">
    </nav>
    <main>
        <section>
        <?php
        $folders = array_slice(scandir('books/'), 2);
        foreach($folders as $folder) {

            // block title
            print  '<button onclick="CloseOpenAccordion(&#34;' . $folder . '&#34;)" id="button_' .  $folder . '" class="button">+ ' . $folder . '</button>' ;
                
                print '<div id="' . $folder . '" class="BooksTypeWithArticle hide">';
                // print  '<h3>' . $folder . '</h3>' ;

                $ArticleArray = array( 'Books', 'Articles', 'Links' ) ;
                foreach($ArticleArray as $Article) {

                    $files = array_slice(scandir('books/' . $folder), 2);
                    $presentFlag = 0 ;
                    foreach($files as $file) {
                        $pos = strrpos($file, ".") + 1 ;
                        $len = strlen($file);
                        $extlen = $len - $pos ;
                        $Ext = substr($file, -$extlen );
                        $FullFileName = 'books/' . $folder . '/' . $file ;
                        $size = filesize( $FullFileName );
                        if ( $size < 500000 )
                            $SmallFileFlag = 1 ;
                        else
                            $SmallFileFlag = 0 ;
                        //print( $size . ' - ' . $SmallFileFlag . ' - ' . $presentFlag . ' - ' . $FullFileName . ' - ' . $Article );
                        if ( (      $Article == 'Links' and         $Ext == 'url') or 
                            (       $Article == 'Books' and         $Ext != 'url' and $SmallFileFlag == 0 ) or
                            (       $Article == 'Articles' and      $Ext != 'url' and $SmallFileFlag == 1 ))
                            $presentFlag = 1 ;
                    }
                
                    if ( $presentFlag == 1 )
                        print '<div class="sub-article">' . $Article . '</div>'    ;
                    
                    print '<div class="BooksTypeWithoutArticle">'   ;
                        
                        $files = array_slice(scandir('books/' . $folder), 2);
                        foreach($files as $file) {
                            $FullFileName = 'books/' . $folder . '/' . $file ;

                            $size = filesize( $FullFileName );
                            if ( $size < 500000 )
                                $SmallFileFlag = 1 ;
                            else
                                $SmallFileFlag = 0 ;
                            //print ($size) ;

                            $pos = strrpos($file, ".") + 1 ;
                            $len = strlen($file);
                            $extlen = $len - $pos ;
                            $Ext = substr($file, -$extlen );

                            $pos = strrpos($file, "[");
                            if ( $pos > 0 )
                                $Lang = substr( $file, $pos + 1, 2 );
                            else
                                $Lang = 'RU' ;

                            if ( $pos > 0 )
                                $BookName = substr( $file, 0, $pos - 1 );
                            else
                                $BookName = substr($file, 0, $len - $extlen - 1 );

                            $pos = strrpos($file, ").");
                            if ( $pos > 0 )
                                $Rating = substr( $file, $pos - 1, 1 );
                            else
                                $Rating = '' ;

                            if ( $Ext == 'url' )
                            {
                                /*
                                $handle = fopen( $FullFileName, "r");
                                $LaunchLink = fread($handle, filesize( $FullFileName ));
                                fclose($handle);
                                */
                                $LaunchLink = file_get_contents( $FullFileName ) ;
                                $BookName = $LaunchLink . ' - ' . $BookName ;   
                            }
                            else
                                $LaunchLink = $FullFileName ;

                            if (        $Rating == 3 )
                                $Ratingtext = '<div class="fa fa-star checked"></div></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
                            else if (   $Rating == 2 )
                                $Ratingtext = '<div class="fa fa-star checked"></div></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span>';
                            else if (   $Rating == 1 )
                                $Ratingtext = '<div class="fa fa-star checked"></div></span><span class="fa fa-star"></span><span class="fa fa-star"></span>' ;
                            else 
                                $Ratingtext = '' ;


                            if ( (      $Article == 'Links' and     $Ext == 'url') or 
                                (       $Article == 'Books' and     $Ext != 'url' and $SmallFileFlag == 0 ) 
                                or (    $Article == 'Articles' and  $Ext != 'url' and $SmallFileFlag == 1 ))
                                Print(
                                    '<div class="row"><a href="' . 
                                    $LaunchLink .
                                    '" target="_blank"><div class="column_bookname">' . 
                                    $BookName .
                                    '</div><div class="column_language">' .
                                    $Lang . 
                                    '</div class="">' .
                                    $Ratingtext .
                                    '</a></div>' );
                        }
                    print '</div>'    ;
                }
            print '</div>'    ;
        }
        print ( '</section>') ;
        ?>
    </main>

    <script>
        function CloseOpenAccordion(button_name) {
            var x = document.getElementById(button_name);
            var id_button = "button_" + button_name;
            var y = document.getElementById(id_button);

            if (x.className.indexOf("show") == -1) {
                x.className += " show";
                document.getElementById(id_button).innerHTML="- " + button_name;
            }
            else { 
                x.className = x.className.replace(" show", "");
                document.getElementById(id_button).innerHTML="+ " + button_name;
            }
        }
    </script>

</body>
<footer>
</footer>
</html>