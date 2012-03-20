<div id="sf_admin_container">
    <div class="inner">
        <h2 class="edit">Sistema de gestión del estado de publicación de los banners y los layout</h2>        
        <div id="sf_admin_content">
            <p>A continuación se detalla el proceso que se ejecuta para mantener despublicados aquellos banners y layouts que no cumplen las condiciones para estar publicados.</p>
            <h3>Banners</h3>
            <div class="clear"></div>
            <ol>
                <li>Se despublican los que no tienen fecha final de publicación.</li>
                <li>Se despublican los que han superado la fecha final de publicación.</li>
                <li>
                    Se seleccionan los que son de tipo "producto".
                    <ol>
                        <li>Se despublican los que no tienen un elemento relacionado.</li>
                        <li style="text-decoration: line-through">Se despublican los que no tienen fecha final de publicación.</li>
                        <li>Se despublican los que han superado la fecha final de publicación.</li>
                    </ol>
                </li>
                <li>
                    Se seleccionan los que son de tipo "contenido".
                    <ol>
                        <li>Se despublican los que no tienen un elemento relacionado.</li>
                        <li style="text-decoration: line-through">Se despublican los que no tienen fecha final de publicación.</li>
                        <li>Se despublican los que han superado la fecha final de publicación.</li>
                    </ol>
                </li>
            </ol>
            <h3>Layouts de las territoriales</h3>
            <div class="clear"></div>
            <ol>
                <li>Se despublican los que no tienen al menos un elemento publicado en cada posición.</li>
            </ol>
            <h3>Layouts de sinersis</h3>
            <div class="clear"></div>
            <ol>
                <li>No se reliza ninguna operación sobre estos layouts.</li>
            </ol>
        </div>        
    </div>
</div>