set terminal png size 1280,720
set output 'Comparacion_393phages_Seq_R1.png'
set title 'Comparacion_393phages_Seq_R1'
set xlabel '393phages'
set ylabel 'Frecuencia'
set xrange [-1:393]
set yrange [0:66]
set mytics 5
set boxwidth 0.9
set style fill solid 0.5
set datafile separator '	'
plot 'datos_para_graficar.txt' using 2:xtic(1) with boxes notitle
