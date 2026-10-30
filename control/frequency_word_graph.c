/**
 * @file frequency_word_graph.c
 * @brief Programa que genera un gráfico de frecuencias absolutas de dos archivos.
 * @author Naiara Gordillo
 * @namespace control
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>

/**
 * @brief Longitud máxima de una línea.
 */
#define MAX_LINE_LENGTH 1024

// Prototipos de funciones
float extraerMaxDeFileName(const char *fileName);
void modificarTitulos(const char *input, char **output);
void graficarFrecuenciasAbsolutas(float max, const char *fileName, const char *name1, const char *name2);

/**
 * @brief Funcion principal del programa.
 *
 * @param argc Número de argumentos.
 * @param argv Argumentos.
 * 
 * @return 0 si se ha ejecutado correctamente, 1 si ha habido algún error.
 */
int main(int argc, char *argv[]) {
    if (argc != 4) {
        fprintf(stderr, "Uso: %s <nombre del fichero> <nombre del archivo> <nombre del archivo>\n", argv[0]);
        return 1;
    }

    const char *fileName = argv[1]; // Nombre del archivo de datos
    const char *name1 = argv[2]; // Nombre del archivo 1
    const char *name2 = argv[3]; // Nombre del archivo 2
    char *fileName1;
    char *fileName2;
    float max;
    
    modificarTitulos(name1, &fileName1);
    modificarTitulos(name2, &fileName2);
    
    max = extraerMaxDeFileName(fileName);
    
    graficarFrecuenciasAbsolutas(max, fileName, fileName1, fileName2);
    
    printf("\n%s\n", fileName);
    printf("Frecuencias_Absolutas_%s_%s.png", fileName1, fileName2);
    
    free(fileName1);
    free(fileName2);
        
    return 0;
}

/**
 * @brief Genera un script de Gnuplot para generar una gráfica de líneas a partir de un archivo de datos.
 * 
 * @param max Valor máximo del eje X.
 * @param fileName Nombre del archivo de datos.
 * @param name1 Nombre del archivo 1.
 * @param name2 Nombre del archivo 2.
 */
void graficarFrecuenciasAbsolutas(float max, const char *fileName, const char *name1, const char *name2) {
    // Generar script de Gnuplot con el ajuste lineal
    FILE *gnuplotScript = fopen("fit_script.gp", "w");
    if (gnuplotScript == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo del script de Gnuplot\n");
        exit(1);
    }

    fprintf(gnuplotScript, "f(x) = m * x + b\n");
    fprintf(gnuplotScript, "fit f(x) '%s' via m, b\n", fileName);
    fprintf(gnuplotScript, "stats '%s' using 1:2\n", fileName);
    fprintf(gnuplotScript, "N = STATS_records\n");
    fprintf(gnuplotScript, "sum_x = STATS_sum_x\n");
    fprintf(gnuplotScript, "sum_y = STATS_sum_y\n");
    fprintf(gnuplotScript, "sum_x2 = STATS_sumsq_x\n");
    fprintf(gnuplotScript, "sum_y2 = STATS_sumsq_y\n");
    fprintf(gnuplotScript, "sum_xy = STATS_sumxy\n");
    fprintf(gnuplotScript, "r = (N * sum_xy - sum_x * sum_y) / sqrt((N * sum_x2 - sum_x**2) * (N * sum_y2 - sum_y**2))\n");
    fprintf(gnuplotScript, "set print 'm_value.txt'\n");
    fprintf(gnuplotScript, "print m, b\n");
    fprintf(gnuplotScript, "set print 'correlation_value.txt'\n");
    fprintf(gnuplotScript, "print r\n");
    fclose(gnuplotScript);

    system("gnuplot fit_script.gp");

    // Generar script de Gnuplot con el valor de la pendiente y la ordenada
    FILE *mValueFile = fopen("m_value.txt", "r");
    if (mValueFile == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo temporal con el valor de m y b\n");
        exit(1);
    }
    double m, b;
    fscanf(mValueFile, "%lf %lf", &m, &b);
    fclose(mValueFile);

    // Generar script de Gnuplot con el valor de r (correlación)
    FILE *rValueFile = fopen("correlation_value.txt", "r");
    if (rValueFile == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo temporal con el valor de r\n");
        exit(1);
    }
    double r;
    fscanf(rValueFile, "%lf", &r);
    fclose(rValueFile);

    // Generar script de Gnuplot para la gráfica
    gnuplotScript = fopen("plot_script.gp", "w");
    if (gnuplotScript == NULL) {
        fprintf(stderr, "No se pudo abrir el archivo del script de Gnuplot\n");
        exit(1);
    }

    fprintf(gnuplotScript, "set terminal png size 1280,720\n");
    fprintf(gnuplotScript, "set title 'Comparativa entre frecuencias de dos secuencias'\n");
    fprintf(gnuplotScript, "set output 'Frecuencias_Absolutas_%s_%s.png'\n", name1, name2);
    fprintf(gnuplotScript, "set xlabel '%s' font 'Arial,10'\n", name1);
	fprintf(gnuplotScript, "set ylabel '%s' font 'Arial,10'\n", name2); 
    fprintf(gnuplotScript, "f(x) = %.6f * x + %.6f\n", m, b);
    fprintf(gnuplotScript, "set xrange [0:%f]\n", max);
    fprintf(gnuplotScript, "set yrange [0:%f]\n", max);
    fprintf(gnuplotScript, "set xtics auto\n");
	fprintf(gnuplotScript, "set mxtics 5\n");
    fprintf(gnuplotScript, "set key outside center bottom spacing 2\n");
    fprintf(gnuplotScript, "plot '%s' using 1:2 with points pointtype 6 notitle, \\\n", fileName);
    fprintf(gnuplotScript, "     x with lines linetype 8 notitle, \\\n");
    fprintf(gnuplotScript, "     f(x) with lines lw 2 title sprintf('Ajuste lineal: y = %.4fx + %.4f : r = %.4f', %.4f, %.4f, %.4f)\n", m, b, r, m, b, r);
    fclose(gnuplotScript);

    system("gnuplot plot_script.gp");

    remove("m_value.txt");
    remove("correlation_value.txt");
}

/**
 * @brief Modifica el nombre de los archivos de entrada para que no tengan la extensión .gz.
 * 
 * @param input Nombre del archivo de entrada.
 * @param output Puntero a un puntero de char donde se almacenará el nombre del archivo de salida.
 */
void modificarTitulos(const char *input, char **output) {
    const char *extension = ".gz";
    size_t input_len = strlen(input);
    size_t ext_len = strlen(extension);

    if (input_len > ext_len && strcmp(input + input_len - ext_len, extension) == 0) {
        const char *punto = strrchr(input, '.');
        if (punto != NULL) {
            size_t new_len = punto - input;
            *output = malloc((new_len + 1) * sizeof(char));
            if (*output == NULL) {
                fprintf(stderr, "No se pudo asignar memoria para el nombre del archivo de salida.\n");
                exit(1);
            }
            strncpy(*output, input, new_len);
            (*output)[new_len] = '\0';
        }
    } else {
        *output = malloc((input_len + 1) * sizeof(char));
        if (*output == NULL) {
            fprintf(stderr, "No se pudo asignar memoria para el nombre del archivo de salida.\n");
            exit(1);
        }
        strcpy(*output, input);
    }
}

/**
 * @brief Extrae el valor de max del nombre del archivo.
 * 
 * @param fileName Nombre del archivo.
 */
float extraerMaxDeFileName(const char *fileName) {
    float max;
    if (sscanf(fileName, "frecuencias_absolutas_%f.txt", &max) == 1) {
        return max;
    } else {
        fprintf(stderr, "No se pudo extraer el valor de max del nombre del archivo.\n");
        exit(1);
    }
}
