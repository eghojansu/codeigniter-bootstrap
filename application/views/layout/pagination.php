<div class="clearfix">
    <div class="pull-right">
        <?php if ($pagination['maxPages'] > 1): ?>
            <?php
                $adjacent = 3;
                $current_url = current_url();
                $current_path = strstr($current_url, '?', true);
                $start = $pagination['currentPage'] <= $adjacent ? 1 : $pagination['currentPage'] - $adjacent;
                $end = $pagination['currentPage'] > $pagination['maxPages'] - $adjacent ? $pagination['maxPages'] : $pagination['currentPage'] + $adjacent;
                $isFirstPage = $pagination['currentPage'] <= 1;
                $isMaxPage = $pagination['currentPage'] >= $pagination['maxPages'];
                $previousPage = $pagination['currentPage'] - 1 < 1 ? 1 : $pagination['currentPage'] - 1;
                $nextPage = $pagination['currentPage'] + 1 <= $pagination['maxPages'] ? $pagination['currentPage'] + 1 : $pagination['currentPage'];
                $path = function($page) use ($current_path) {
                    $query = $_GET;
                    $query['page'] = $page;

                    return $current_path.'?'.http_build_query($query);
                }
            ?>

            <ul class="pagination pagination-sm" style="margin-bottom: 0">
                <li <?php echo $isFirstPage ? 'class="disabled"' : '' ?>>
                    <a href="<?php echo $isFirstPage ? '#' : $path(1) ?>">&laquo;</a>
                </li>

                <li <?php echo $isFirstPage ? 'class="disabled"' : '' ?>>
                    <a href="<?php echo $isFirstPage ? '#' : $path($previousPage) ?>">&lsaquo;</a>
                </li>

                <?php if ($start > 1): ?>
                    <li class="disabled">
                        <a style="cursor:default" href="#">&hellip;</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++): ?>
                <li <?php echo $pagination['currentPage'] == $i ? 'class="active"' : '' ?>>
                    <a href="<?php echo $path($i) ?>"><?php $i ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($end < $pagination['maxPages']): ?>
                    <li class="disabled">
                        <a style="cursor:default" href="#">&hellip;</a>
                    </li>
                <?php endif; ?>

                <li <?php echo $isMaxPage ? 'class="disabled"' : '' ?>>
                    <a href="<?php echo $isMaxPage ? '#' : $path($nextPage) ?>">&rsaquo;</a>
                </li>

                <li <?php echo $isMaxPage ? 'class="disabled"' : '' ?>>
                    <a href="<?php echo $isMaxPage ? '#' : $path($pagination['maxPages']) ?>">&raquo;</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
    <p>Displaying <?php echo $pagination['recordCount'] ? $pagination['firstNumber'] + 1 : 0 ?> - <?php echo $pagination['firstNumber'] + $pagination['recordCount'] ?> of <?php echo $pagination['totalRecord'] ?> record</p>
</div>

