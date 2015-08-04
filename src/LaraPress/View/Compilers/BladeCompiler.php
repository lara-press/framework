<?php namespace LaraPress\View\Compilers;

use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeCompiler extends BaseBladeCompiler
{
    /**
     * Compile the loop statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileLoop($expression)
    {
        return '<?php if (have_posts()) : while(have_posts()) : the_post(); ?>';
    }

    /**
     * Compile the endloop statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileEndloop($expression)
    {
        return '<?php endwhile; endif; ?>';
    }

    /**
     * Compile the query statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileQuery($expression)
    {
        return
            '<?php $__query = new WP_Query('
            . $expression
            . '); if ($__query->have_posts()) : while($__query->have_posts()) : $__query->the_post(); ?>';
    }

    /**
     * Compile the endquery statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileEndquery($expression)
    {
        return '<?php endwhile; endif; wp_reset_postdata(); ?>';
    }


    /**
     * Compile set statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileSet($expression)
    {
        return '<?php ' . $expression . '?>';
    }

    /**
     * Compile the sidebar statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileSidebar($expression)
    {
        return '<?php dynamic_sidebar(' . $expression . '); ?>';
    }

    /**
     * Compile the JS enqueue statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileJs($expression)
    {
        return '<?php wp_enqueue_script' . $expression . '; ?>';
    }

    /**
     * Compile the JS enqueue statement into valid PHP.
     *
     * @param string $expression
     *
     * @return string
     */
    protected function compileCss($expression)
    {
        return '<?php wp_enqueue_style' . $expression . '; ?>';
    }

    /**
     * Compile the wp_footer statement into valid PHP.
     *
     * @return string
     */
    protected function compileWpFooter()
    {
        return '<?php wp_footer(); ?>';
    }

    /**
     * Compile the wp_head statement into valid PHP.
     *
     * @return string
     */
    protected function compileWpHead()
    {
        return '<?php wp_head(); ?>';
    }
}
